//
//  AppManager.m
//  X-Project
//
//  Created by Admin on 6/2/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "AppManager.h"
#import "Constants.h"

static AppManager *sharedAppManager = nil;
@interface AppManager()
@property (nonatomic,strong) NSString *user_Token;
@property (nonatomic,strong) NSString *user_id;
@property (readwrite) double currnetLogitude;
@property (nonatomic, readwrite) double currentLatitude;
@end

@implementation AppManager
+ (instancetype) sharedManager{
    static dispatch_once_t  Token;
    dispatch_once(&Token, ^{
        sharedAppManager = [[AppManager alloc] init];
    });
    
    return sharedAppManager;
}
- (void)setUserToken:(NSString *)token{
    if (token) {
        self.user_Token = token;
        NSLog(@"%@", token);
        [[NSUserDefaults standardUserDefaults] setObject:token forKey:USER_TOKEN];
    }
}
- (NSString *)getUserToken{
    if ( self.user_Token == nil ) {
        self.user_Token = [[NSUserDefaults standardUserDefaults] objectForKey:USER_TOKEN];
    }
    return self.user_Token;
}

-(void)setUserID:(NSString *)_id{
    if(_id){
        self.user_id = _id;
        [[NSUserDefaults standardUserDefaults] setObject:_id forKey:USER_ID];
    }
}
-(NSString *)getUserID{
    if (self.user_id == nil) {
        self.user_id = [[NSUserDefaults standardUserDefaults] objectForKey:USER_ID];
    }
    return self.user_id;
}
-(void)setCurrentLatitude:(double)latitude   {
    self.currentLatitude = latitude;
}
-(void)setCurrentLongitude:(double)longitude    {
    self.currnetLogitude = longitude;
}
- (double)getCurrentLatitude    {
    return self.currentLatitude;
}
- (double)getCurrentLongitude   {
    return self.currnetLogitude;
}

- (NSString *)getAddress    {
    return self.address;
}
@end
