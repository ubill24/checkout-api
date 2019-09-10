# Checkout API
Checkout API - for e-commerce integration

## Sample codes
### Web
* [Python Flask](https://github.com/ubill24/checkout-api/tree/master/examples/web/flask)
* [PHP](https://github.com/ubill24/checkout-api/tree/master/examples/web/php)
* C# ASP.NET MVC (Comming soon...)

### E-Commerce
* Magento
* OpenCart (Comming soon...)
* [Woocommerce](https://github.com/ubill24/checkout-api/tree/master/examples/web/woocommerce-bill24-payment-gateway)

### Mobile
* [Android Native](https://github.com/ubill24/checkout-api/tree/master/examples/mobile/android)
* [iOS Native ](https://github.com/ubill24/checkout-api/tree/master/examples/mobile/ios)
### Objective-C
*   Call Javascript Event ( myOwnJSHandler )

    WKUserContentController *userContentController = [[WKUserContentController alloc] init];
    WKWebViewConfiguration *configuration = [[WKWebViewConfiguration alloc] init];
    [userContentController addScriptMessageHandler: self name:@"myOwnJSHandler"];
    configuration.userContentController = userContentController;
     CGRect frame = CGRectMake([[UIScreen mainScreen] bounds].origin.x, [[UIScreen mainScreen] bounds].origin.y, [[UIScreen         mainScreen] bounds].size.width, [[UIScreen mainScreen] bounds].size.height);
     
     _webview = [[WKWebView alloc] initWithFrame:frame configuration:configuration];
    // afer get url
    NSURL *url = [NSURL URLWithString:@"https://demo.bill24.net/checkout/eyJhbG...."];
    NSURLRequest *urlRequest = [NSURLRequest requestWithURL:url];
    
    [_webview loadRequest:urlRequest];
    
    [self.view addSubview:_webview];
    
*   Get Data from Javascript

    - (void)userContentController:(WKUserContentController *)userContentController didReceiveScriptMessage:(WKScriptMessage         *)message {
    
        NSLog(@"%@", message.body);
    }
    
    
* [IOS Objective-C ] (https://github.com/ubill24/checkout-api/tree/master/examples/mobile/ios-objective-c/B24%20Checkout)
* [ReactNative (iOS+Android)](https://github.com/ubill24/checkout-api/tree/master/examples/mobile/react)
* Flutter (iOS+Android) (Comming soon...)
