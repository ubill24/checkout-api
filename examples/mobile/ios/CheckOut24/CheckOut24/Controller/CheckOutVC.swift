//
//  CheckOutVC.swift
//  CheckOut24
//
//  Created by Youra Leangseng on 8/8/18.
//  Copyright © 2018 Youra Leangseng. All rights reserved.
//
import Foundation
import UIKit
import WebKit
import WKBridge
import SwiftyJSON

struct MyData: Codable {
    let code: String?
    private enum CodingKeys: String, CodingKey {
        case code
    }
}

class CheckOutVC: UIViewController, WKNavigationDelegate {
    var webView : WKWebView!
    var activityIndicator: UIActivityIndicatorView!
    var receiveData = "https://www.google.com"
    
    struct jsonResponse: Codable {
        var message: String
        var code: String
    }
    deinit {
        webView.removeBridge()
    }
    
    override func loadView() {
        let webConfiguration = WKWebViewConfiguration()
        webView = WKWebView(frame: .zero, configuration: webConfiguration)
        webView.uiDelegate = self as? WKUIDelegate
        view = webView
    }
    
    func back(sender: UIBarButtonItem) {
        // Perform your custom actions
        // ...
        // Go back to the previous ViewController
        _ = navigationController?.popViewController(animated: true)
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        self.title = "Check Out"
        self._handleWebView(url: receiveData)
    }
    
    func _handleWebView(url: String) {
        let url = URL(string: url)
        let request = URLRequest(url: url!)
        
        webView.load(request)
        
        activityIndicator = UIActivityIndicatorView()
        activityIndicator.center = self.view.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.activityIndicatorViewStyle = UIActivityIndicatorViewStyle.gray
        self.view.addSubview(activityIndicator)
        self.view.sendSubview(toBack: webView)
        
        webView.bridge.printScriptMessageAutomatically = true
        
        webView.bridge.register({ (parameters, completion) in
            if let data:String = parameters?["message"] as? String{
                do{
                    let json = JSON(data)
                    let stringval:String = json.rawValue as! String
                    let jsonData = stringval.data(using: .utf8)!
                    let decoder = JSONDecoder()
                    let jsonDATA = try! decoder.decode(MyData.self, from: jsonData)
                    let getCode: String = jsonDATA.code!
                    if(getCode == "SUCCESS"){
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "successVc") as? SuccessVC {
                            viewController.receiveData = json
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }else if(getCode == "PENDING"){
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "invoice") as? InvoiceVC {
                            viewController.receiveData = json
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }else if(getCode == "400"){
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "error") as? ErrorVC {
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }else if(getCode == "499"){
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "cancel") as? CancelVC {
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }else if(getCode == "CANCEL"){
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "cancel") as? CancelVC {
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }else{
                        if let viewController = UIStoryboard(name: "Main", bundle: nil).instantiateViewController(withIdentifier: "confirm") as? ViewController {
                            if let navigator = self.navigationController {
                                navigator.pushViewController(viewController, animated: true)
                            }
                        }
                    }
                }catch let err{
                    print("errr ",err)
                }
            }
        }, for: "print")
    }
    
    func showActivityIndicator(show: Bool) {
        if show {
            activityIndicator.startAnimating()
        } else {
            activityIndicator.stopAnimating()
        }
    }
    
    func webView(_ webView: WKWebView, didFinish navigation: WKNavigation!) {
        showActivityIndicator(show: false)
    }
    
    func webView(_ webView: WKWebView, didStartProvisionalNavigation navigation: WKNavigation!) {
        showActivityIndicator(show: true)
    }
    
    func webView(_ webView: WKWebView, didFail navigation: WKNavigation!, withError error: Error) {
        showActivityIndicator(show: false)
    }
    
}

