//
//  MenuItem.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "MenuItem.h"

@implementation MenuItem

- (instancetype) init:(NSString*)title controller:(UINavigationController*)controller
{
    self = [super init];
    if ( self ) {
        _menuTitle = title;
        _isSelected = NO;
        self.controller = controller;
    }
    return self;
}

@end
