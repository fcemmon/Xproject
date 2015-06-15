//
//  MenuItemView.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "MenuItemView.h"

@implementation MenuItemView

@synthesize menuItem;
@synthesize menuTitleLabel;

- (instancetype)initWithFrame:(CGRect)frame {
    self = [super initWithFrame:frame];
    if (self) {
    }
    return self;
}

- (id) initWithCoder:(NSCoder *)aDecoder {
    self = [super initWithCoder:aDecoder];
    if ( self ) {
    }
    return self;
}

#pragma mark - Initialize

- (void) setupView:(MenuItem*)menu delegate:(id<MenuItemViewDelegate>)delegate {
    _delegate = delegate;
    menuItem = menu;
    if ( menuItem ) {
        [self select:menuItem.isSelected];
        [menuTitleLabel setText:menuItem.menuTitle];
    }
}

#pragma mark - TouchEvent

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event {
    [super touchesBegan:touches withEvent:event];
    [self select:YES];
}

- (void)touchesEnded:(NSSet *)touches withEvent:(UIEvent *)event {
    [super touchesEnded:touches withEvent:event];
    [self setNeedsDisplay];
    if ( self.delegate ) {
        [self.delegate didClickMenuItem:self];
    }
}

- (void)touchesCancelled:(NSSet *)touches withEvent:(UIEvent *)event {
    [super touchesCancelled:touches withEvent:event];
    [self setNeedsDisplay];
    [self select:NO];
}

- (void) select:(BOOL)isSelected
{
    menuItem.isSelected = isSelected;
}

@end
