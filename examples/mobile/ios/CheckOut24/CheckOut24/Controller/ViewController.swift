//
//  ViewController.swift
//  CheckOut24
//
//  Created by Youra Leangseng on 8/8/18.
//  Copyright © 2018 Youra Leangseng. All rights reserved.
//

import UIKit
import SwiftyJSON


struct GeceiveData: Codable {
    let message: String?
    let code: String?
    let data: MyDATA?
    
    private enum CodingKeys: String, CodingKey {
        case message
        case code
        case data
    }
}

struct MyDATA: Codable
{
    let payment_url: String?
    let tran_id: String?
}

class ViewController: UIViewController {
    var activityIndicator: UIActivityIndicatorView!
    let TOKEN:String = "a8024ffe355342ef890fcebed5ad3009"
    let BAE_URL:String = "https://checkoutapi-demo.bill24.net"
    var parameters = ["description": "Description" ,"currency": "USD", "amount":100, "reference_id": "YOURA869718501", "webview": true] as [String : Any]
    
    @IBOutlet weak var api_token: UITextField!
    @IBOutlet weak var amount: UITextField!
    @IBOutlet weak var currency: UITextField!
    @IBOutlet weak var descriptionText: UITextField!
   
   
    @IBAction func CheckOutOrder() {
        var _: String = api_token.text!
        let amountEt: String = amount.text!
        let currencyEt: String = currency.text!
        let descriptionEt: String = descriptionText.text!
        
        parameters = ["description": descriptionEt ,"currency": currencyEt, "amount":amountEt, "reference_id": "YOURA869718501", "webview": true] as [String : Any]
        
        showActivityIndicator(show: true)
        guard let url = URL(string: BAE_URL+"/transaction/init") else{return}
        var request = URLRequest(url: url)
        let headers = ["Accept":"application/json","Content-Type":"application/json","token":TOKEN];
        request.allHTTPHeaderFields = headers
        request.httpMethod = "POST"
        guard let httpBody = try? JSONSerialization.data(withJSONObject: parameters, options: []) else {
            return
        }
        request.httpBody = httpBody
        let session = URLSession.shared
        let task = session.dataTask(with: request){ (data, response, error)in
            if let data = data{
                do{
                    let json = try JSON(data: data)
                    DispatchQueue.main.async {
                        let user: Dictionary<String, JSON> = json["data"].dictionaryValue
                        let jsonUser = JSON(user)
                        let url: String = jsonUser["payment_url"].stringValue
                        self._handleWebView(url: url)
                    }
                }catch{
                  print("Error")
                }
            }
        }
        task.resume()
    }
    func _handleWebView(url: String)  {
        showActivityIndicator(show: false)
        if (url != ""){
            let checkOutVc = CheckOutVC()
            checkOutVc.receiveData = url
            self.navigationController?.pushViewController(checkOutVc, animated: false)
        }
    }
    override func viewDidLoad() {
        super.viewDidLoad()
        
        api_token.text=TOKEN
        amount.text = "100"
        currency.text = "USD"
        descriptionText.text = "Checkout from e-commerce mobile."
        
        activityIndicator = UIActivityIndicatorView()
        activityIndicator.center = self.view.center
        activityIndicator.hidesWhenStopped = true
        activityIndicator.activityIndicatorViewStyle = UIActivityIndicatorViewStyle.gray
        self.view.addSubview(activityIndicator)
    }

    func showActivityIndicator(show: Bool) {
        if show {
            activityIndicator.startAnimating()
        } else {
            activityIndicator.stopAnimating()
        }
    }
}

