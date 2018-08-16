//
//  SuccessVC.swift
//  CheckOut24
//
//  Created by Youra Leangseng on 8/8/18.
//  Copyright © 2018 Youra Leangseng. All rights reserved.


import UIKit
import SwiftyJSON

struct ReceiveData: Codable {
    let message: String?
    let code: String?
    let data:DATA?
    
    private enum CodingKeys: String, CodingKey {
        case message
        case code
        case data
    }
}

struct DATA: Codable
{
    let fee_amount: Double?
    let total_amount: Double?
    let tran_amount: Double?
    let reference_id: String?
    let currency: String?
    let bank_reference_no: String?
    let tran_id: String?
    let tran_date: String?
}

class SuccessVC: UIViewController {
    var receiveData:JSON!
    var uiViews = UIView()
    var labeltext1 = UILabel()
    let leftBarButtonItem: UIBarButtonItem = {
        let barButtonItem = UIBarButtonItem(title: "Back",style: .plain, target: nil, action: nil)
        barButtonItem.tintColor = UIColor.black
        return barButtonItem
    }()
    
    @IBOutlet weak var bank_reference_no: UILabel!
    @IBOutlet weak var transaction_no: UILabel!
    @IBOutlet weak var total_amount: UILabel!
    
    @IBOutlet weak var amount: UILabel!
    @IBOutlet weak var fee_amount: UILabel!
    @IBOutlet weak var date: UILabel!
    override func viewDidLoad() {
        super.viewDidLoad()
    
        let stringval:String = receiveData.stringValue
        let jsonData = stringval.data(using: .utf8)!
        let decoder = JSONDecoder()
        let jsonDATA = try! decoder.decode(ReceiveData.self, from: jsonData)

        let bank_referenceT: String = (jsonDATA.data?.bank_reference_no)!
        let transaction_noT: String = (jsonDATA.data?.tran_id)!
        let total_amountT: Double = (jsonDATA.data?.total_amount)!
        let amountT: Double = (jsonDATA.data?.tran_amount)!
        let fee_amountT: Double = (jsonDATA.data?.fee_amount)!
        let dateT: String = (jsonDATA.data?.tran_date)!
        
        bank_reference_no.text = bank_referenceT
        transaction_no.text = transaction_noT
        amount.text = String(amountT)
        fee_amount.text = String(fee_amountT)
        total_amount.text = String(total_amountT)
        date.text = dateT
    }
}
