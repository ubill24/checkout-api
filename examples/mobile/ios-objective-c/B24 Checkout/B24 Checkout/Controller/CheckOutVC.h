//
//  CheckOutVC.h
//  B24 Checkout
//
//  Created by Youra Dev on 9/9/19.
//  Copyright © 2019 Youra Dev. All rights reserved.
//
#import <UIKit/UIKit.h>
#import <WebKit/WebKit.h>

@interface CheckOutVC : UIViewController <WKScriptMessageHandler>

@property(nonatomic, strong) WKWebView *webview;

@property (nonatomic, assign) BOOL isSomethingEnabled;

@end


