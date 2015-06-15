//
//  MenuItem.h
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>

@interface MenuItem : NSObject

@property (nonatomic, assign) BOOL isSelected;
@property (nonatomic, strong) NSString *iconName;
@property (nonatomic, strong) NSString *iconSelectedName;
@property (nonatomic, strong) NSString *menuTitle;
@property (nonatomic, strong) UINavigationController *controller;

- (instancetype) init:(NSString*)title controller:(UINavigationController*)controller;

@end
