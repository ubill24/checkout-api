//
//  InvoiceVC.swift
//  CheckOut24
//
//  Created by Youra Leangseng on 8/17/18.
//  Copyright © 2018 Youra Leangseng. All rights reserved.
//

import UIKit
import SwiftyJSON
import QRCode
import Kingfisher

struct InvoiceData: Codable {
    let message: String?
    let code: String?
    let data:INDATA?
    
    private enum CodingKeys: String, CodingKey {
        case message
        case code
        case data
    }
}

struct INDATA: Codable
{
    let bill_code: String?
    let amount: Double?
    let reference_id: String?
    let currency: String?
    let tran_id: String?
    let bill_date: String?
    let payment_url: String?
    let description: String?
    let biller_codes: Array<String>?
}

struct Photo{
    let name: String
    var comments: String?
    lazy var image: UIImage? = {
        return UIImage(named: self.name)
    }()
    init(name: String){
        self.name = name
    }
}


class InvoiceVC: UIViewController, UICollectionViewDelegate, UICollectionViewDataSource {
    
    var receiveData:JSON!
    var uiViews = UIView()
    var labeltext1 = UILabel()
    
    let leftBarButtonItem: UIBarButtonItem = {
        let barButtonItem = UIBarButtonItem(title: "Back",style: .plain, target: nil, action: nil)
        barButtonItem.tintColor = UIColor.black
        return barButtonItem
    }()
    
    var qrcodeImage: CIImage!
    var images = [UIImage]()
    var imageArray = [URL]()
    var listImage = [String]()
    
    @IBOutlet weak var uiImageView: UIImageView!
    
    @IBOutlet weak var imageView: UIImageView!
    @IBOutlet weak var invoice_no: UILabel!
    @IBOutlet weak var reference_no: UILabel!
    @IBOutlet weak var date: UILabel!
    @IBOutlet weak var amount: UILabel!
    @IBOutlet weak var desc: UILabel!
    @IBOutlet weak var currency: UILabel!
    
    @IBOutlet weak var borderBottomView: UIView!
    override func viewDidLoad() {
        super.viewDidLoad()

        let stringval:String = receiveData.stringValue
        let jsonData = stringval.data(using: .utf8)!
        let decoder = JSONDecoder()
        let jsonDATA = try! decoder.decode(InvoiceData.self, from: jsonData)
        
        let invoiceNoEt: String = (jsonDATA.data?.bill_code)!
        let referenceNoEt: String = (jsonDATA.data?.reference_id)!
        let dateEt: String = (jsonDATA.data?.bill_date)!
        let amountEt: Double = (jsonDATA.data?.amount)!
        let descEt: String = (jsonDATA.data?.description)!
        let currencyEt: String = (jsonDATA.data?.currency)!
        let payment_url: String = (jsonDATA.data?.payment_url)!
        
        let dataQr = payment_url.data(using: .ascii, allowLossyConversion: false)
        let filter = CIFilter(name: "CIQRCodeGenerator")
        filter?.setValue(dataQr, forKey: "inputMessage")
        
        let img = UIImage(ciImage: (filter?.outputImage)!)
        
        imageView.image = img
        
        invoice_no.text = invoiceNoEt
        reference_no.text = referenceNoEt
        date.text = dateEt
        amount.text = String(amountEt)
        desc.text = descEt
        currency.text = currencyEt
        
        listImage = (jsonDATA.data?.biller_codes)!
    }
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return listImage.count
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "ImageCollectionViewCell", for: indexPath) as! ImageCollectionViewCell
        let resource = ImageResource(downloadURL: URL(string: listImage[indexPath.row] )!)
        cell.imgImage.kf.setImage(with: resource)
        return cell
    }
}
