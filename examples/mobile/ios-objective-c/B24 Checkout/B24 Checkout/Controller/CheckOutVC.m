//
//  CheckOutVC.m
//  B24 Checkout
//
//  Created by Youra Dev on 9/9/19.
//  Copyright © 2019 Youra Dev. All rights reserved.
//

#import <Foundation/Foundation.h>

#import "CheckOutVC.h"

@interface CheckOutVC ()

@end

@implementation CheckOutVC

- (void)viewDidLoad {
    [super viewDidLoad];
    self.title = @"Check Out";
    // Do any additional setup after loading the view, typically from a nib.
    WKUserContentController *userContentController = [[WKUserContentController alloc] init];
    WKWebViewConfiguration *configuration = [[WKWebViewConfiguration alloc] init];
    [userContentController addScriptMessageHandler: self name:@"myOwnJSHandler"];
    configuration.userContentController = userContentController;
    
    CGRect frame = CGRectMake([[UIScreen mainScreen] bounds].origin.x, [[UIScreen mainScreen] bounds].origin.y, [[UIScreen mainScreen] bounds].size.width, [[UIScreen mainScreen] bounds].size.height);
    
    _webview = [[WKWebView alloc] initWithFrame:frame configuration:configuration];
    // afer get url
    NSURL *url = [NSURL URLWithString:@"https://demo.bill24.net/checkout/eyJhbGciOiJIUzI1NiIsImV4cCI6MTU2ODAwOTkzNiwiaWF0IjoxNTY4MDA2MzM2fQ.eyJ0aWQiOiJvNnluSFR1ZCIsImxhbmciOiJrbSJ9.ntZGKkytAvx1Pif_StwEjkUit_la39zw4unsjHj3v8E"];
    NSURLRequest *urlRequest = [NSURLRequest requestWithURL:url];
    
    [_webview loadRequest:urlRequest];
    
    [self.view addSubview:_webview];
    
}


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)userContentController:(WKUserContentController *)userContentController didReceiveScriptMessage:(WKScriptMessage *)message {
    
    NSLog(@"%@", message.body);
}


@end
