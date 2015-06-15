//
//  MenuViewController.h
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//
#import <UIKit/UIKit.h>

@interface MenuViewController : UIViewController<UITableViewDataSource, UITableViewDelegate>

@property (weak, nonatomic) IBOutlet UITableView *tableView;

@end
