//
//  ViewController.m
//  B24 Checkout
//
//  Created by Youra Dev on 9/9/19.
//  Copyright © 2019 Youra Dev. All rights reserved.
//

#import "ViewController.h"
#import "CheckOutVC.h"

@interface ViewController ()

@end

@implementation ViewController
- (IBAction)api_token:(UITextField *)sender {
}
- (IBAction)amount:(id)sender {
}


- ( void )viewDidLoad
{
    [super viewDidLoad];
    self.title = @"Confirm Order";
}

- (IBAction)CheckOutOrder:(id)sender {
    [self handleCheckout];
}

- ( void )handleCheckout
{
    NSString *TOKEN = @"a8024ffe355342ef890fcebed5ad3009";
    NSString *BASE_URL= @"https://checkoutapi-demo.bill24.net/transaction/init";
    NSDictionary *jsonBodyDict = @{@"description": @"Description" ,@"currency": @"USD", @"amount":@100, @"reference_id": @"YOURA869718501", @"webview": @true, @"pay_later_url": @"https://checkoutapi-demo.bill24.net/checkout/pay-later"};
    NSData *postData = [NSJSONSerialization dataWithJSONObject:jsonBodyDict options:kNilOptions error:nil];
    
    NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
    // insert whatever URL you would like to connect to
    [request setURL:[NSURL URLWithString:BASE_URL]];
    [request setHTTPMethod:@"POST"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Accept"];
    [request setValue:@"application/json" forHTTPHeaderField:@"Content-Type"];
    [request setValue:TOKEN forHTTPHeaderField:@"token"];
    [request setHTTPBody:postData];
    
    NSURLSessionDataTask *task = [[self getURLSession] dataTaskWithRequest:request completionHandler:^( NSData *data, NSURLResponse *response, NSError *error )
                                  {
                                      dispatch_async( dispatch_get_main_queue(),
                                                     ^{
                                                         // parse returned data
                                                         NSString *result = [[NSString alloc] initWithData:data encoding:NSASCIIStringEncoding];
                                                         
                                                         NSLog( @"%@", result );
                                                         NSData *data = [result dataUsingEncoding:NSUTF8StringEncoding];
                                                         id json = [NSJSONSerialization JSONObjectWithData:data options:0 error:nil];
                                                         NSLog(@"%@",[json valueForKeyPath:@"data.payment_url"]);
                                                     } );
                                  }];
    
    [task resume];
    
   [self navigateToMyNewViewController];
}

- (void)navigateToMyNewViewController {
    UIStoryboard *storyboard = [UIStoryboard storyboardWithName:@"Main"bundle:nil];
    CheckOutVC *myNewVC = (CheckOutVC*)[storyboard instantiateViewControllerWithIdentifier:@"CheckOutVC"];
    [self.navigationController pushViewController:myNewVC animated:YES];
}

- ( NSURLSession * )getURLSession
{
    static NSURLSession *session = nil;
    static dispatch_once_t onceToken;
    dispatch_once( &onceToken,
                  ^{
                      NSURLSessionConfiguration *configuration = [NSURLSessionConfiguration defaultSessionConfiguration];
                      session = [NSURLSession sessionWithConfiguration:configuration];
                  } );
    
    return session;
}


- ( void )didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
