//
//  ContactsViewController.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "ContactsViewController.h"
#import "METransitions.h"
#import "MEDynamicTransition.h"
#import <UIViewController+ECSlidingViewController.h>
#import <MBProgressHUD.h>
#import <APAddressBook.h>
#import <APContact.h>
#import "Constants.h"
#import <AFNetworking.h>
#import "AppManager.h"

@interface ContactsViewController (){
    NSArray *sortedcontactsArray;
    NSMutableArray *phonenumbers;
    NSArray *sectionheaders;
    NSMutableArray * registeredUserIndexList;
    NSMutableArray * registeredContectList;
    int currentPosition;
    NSString * setting_Favorite;
}
@property (nonatomic, strong) METransitions *transitions;
@property (nonatomic, strong) UIPanGestureRecognizer *dynamicTransitionPanGesture;
@property (nonatomic, strong) NSString *user_id;
@property (nonatomic, strong) AppManager *appManager;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activityIdentifier;

@end

@implementation ContactsViewController

@synthesize appManager;

- (void)viewDidLoad {
    [super viewDidLoad];
    sectionheaders = [[NSArray alloc] init];
    appManager = [AppManager sharedManager];
    self.user_id = [appManager getUserID];
    phonenumbers = [[NSMutableArray alloc] init];
    registeredUserIndexList = [[NSMutableArray alloc] init];
    registeredContectList = [[NSMutableArray alloc] init];
    [self getAllContactsFromPhone];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    [self setGesture];
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    [self removeGesture];
}

#pragma mark - Get all contact form phone

/////========================================================
-(void)getAllContactsFromPhone{
    MBProgressHUD *hud = [MBProgressHUD showHUDAddedTo:self.view animated:YES];
    hud.mode = MBProgressHUDModeAnnularDeterminate;
    hud.labelText = @"Loading Contacts...";
    APAddressBook *addressBook = [[APAddressBook alloc] init];
    addressBook.filterBlock = ^BOOL(APContact *contact)
    {
        return contact.phones.count > 0;
    };
    
    [addressBook loadContacts:^(NSArray *contacts, NSError *error) {
        [hud hide:YES];
        if ( !error ) {
            if ( contactsArray == nil ) {
                contactsArray = [[NSMutableArray alloc] init];
            }
            else {
                [contactsArray removeAllObjects];
            }
            
            for ( int i = 0; i < contacts.count && i < 1000; i++ ) {
                APContact *contact = contacts[i];
                if ( contact.phones && contact.phones.count > 0 ) {
                    NSMutableDictionary *dict = [[NSMutableDictionary alloc] init];
                    if ( contact.firstName )
                        [dict setObject:contact.firstName forKey:@"firstName"];
                    else
                        [dict setObject:@"" forKey:@"firstName"];
                    
                    if ( contact.lastName )
                        [dict setObject:contact.lastName forKey:@"lastName"];
                    else
                        [dict setObject:@"" forKey:@"lastName"];
                    
                    if ( contact.emails && contact.emails.count > 0 )
                        [dict setObject:contact.emails[0] forKey:@"email"];
                    else
                        [dict setObject:@"" forKey:@"email"];
                    
                    NSMutableArray *phoneNumbers = [[NSMutableArray alloc] init];
                    for ( int j = 0; j < [contact.phones count]; j++ ) {
                        [phoneNumbers addObject:contact.phones[j]];
                        [phonenumbers addObject:contact.phones[j]];
                    }
                    [dict setObject:phoneNumbers forKey:@"phone"];
                    [contactsArray addObject:dict];
                }
            }
            NSLog(@"%@", contactsArray);
            NSSortDescriptor *brandDescriptor = [[NSSortDescriptor alloc] initWithKey:@"firstName" ascending:YES];
            NSArray *sortDescriptors = [NSArray arrayWithObject:brandDescriptor];
            sortedcontactsArray = [contactsArray sortedArrayUsingDescriptors:sortDescriptors];
            [self getContacts];
        }
        else {
            UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:nil message:error.localizedDescription delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
            [alertView show];
        }
    }];
}
- (void)createAlertView:(NSString *)message {
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Message" message:message delegate:nil cancelButtonTitle:nil otherButtonTitles:@"OK", nil];
    [alert show];
}

#pragma mark Get Contacts API

- (void) getContacts{
    registeredContectList = [[NSMutableArray alloc] init];
    NSString *string_url = [NSString stringWithFormat:@"%@%@", mHostURL,mContact];
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSLog(@"%@", phonenumbers);
    NSDictionary *parameters = @{@"user_id": self.user_id,
                                 @"phonenumbers": phonenumbers};
    
    [self.activityIdentifier startAnimating];
    
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        
        [self.activityIdentifier stopAnimating];
        
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            if ([[jsonResult objectForKey:@"count"] isEqualToNumber:[NSNumber numberWithInt:0]]) {
                [self.contactList reloadData];
                NSLog(@"%s", "No datas");
            }else{
                NSArray *service_contacts = [jsonResult objectForKey:@"contacts"];
                
                int registereIndex[100];
                for (int i = 0; i < 100; i ++) {
                    registereIndex[i] = 100;
                }
                
                for (int i = 0; i < [service_contacts count]; i++) {
                    NSDictionary * registeredContact = [service_contacts objectAtIndex:i];
                    [registeredContectList addObject:registeredContact];
                    BOOL isRegisteredUser = FALSE;
                    for (int j = 0; j<[contactsArray count]; j ++) {
                        NSMutableArray * phoneNumber = [[contactsArray objectAtIndex:j] objectForKey:@"phone"];
                        for (int k = 0; k < [phoneNumber count] ; k ++) {
                            
                        if ([[phoneNumber objectAtIndex:k ] isEqual:[registeredContact objectForKey:@"phonenumber"]]) {
                            [registeredUserIndexList addObject:[contactsArray objectAtIndex:j]];
                            isRegisteredUser = TRUE;
                            registereIndex[i] = j;
                            break;
                        }
                        }
                        if (isRegisteredUser) {
                            break;
                        }
                    }
                }
                for (int i = 0; i < 100; i ++) {
                    if (registereIndex[i] != 100) {
                        [contactsArray removeObjectAtIndex:registereIndex[i]];
                    }
                }
                [self.contactList reloadData];
            }
        }
        else{
            [[[UIAlertView alloc] initWithTitle:@"Failed" message:@"Failed to read data from server" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
            [self.contactList reloadData];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
        [self.activityIdentifier stopAnimating];
    }];
}

- (void)setFavorite:(NSString *)userid phone:(NSString *)phoneNumber email:(NSString *)email favorite:(NSString *)favorite  {
    NSString *string_url = [NSString stringWithFormat:@"%@%@", mHostURL,mSetFavorite];
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"user_id": self.user_id,
                               @"phonenumber": phoneNumber,
                                @"email":email,
                                 @"favorite":favorite};
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            [self getContacts];
        }
        else{
            [[[UIAlertView alloc] initWithTitle:@"Failed" message:@"Failed to read data from server" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
    }];
}

#pragma mark - UITableViewDB Source

-(NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return 2;
}

- (CGFloat)tableView:(UITableView *)tableView heightForHeaderInSection:(NSInteger)section{
    return 30;
}

-(NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section{
    if (section == 0) {
        return @"Service contacts";
    }else{
        return @"Normal contacts";
    }
}

-(CGFloat) tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 50;
}
-(NSInteger) tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    NSLog(@"%lu", (unsigned long)[contactsArray count]);
    return [contactsArray count];
}
-(UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    static NSString *MyIdentifier = @"Cell";
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:MyIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault  reuseIdentifier:MyIdentifier];
    }
    cell.backgroundColor = [UIColor clearColor];
    if (indexPath.section == 0) {
//        cell.
        if ([registeredUserIndexList count] > indexPath.row) {
            NSString *contact_name = [NSString stringWithFormat:@"%@ %@", [registeredUserIndexList[indexPath.row] objectForKey:@"firstName"],[registeredUserIndexList[indexPath.row] objectForKey:@"lastName"]];
            cell.textLabel.text = contact_name;
            NSArray * phonenumber = [registeredUserIndexList[indexPath.row] objectForKey:@"phone"];
            for (int i = 0; i < [phonenumber count]; i ++) {
                if ([[[registeredContectList objectAtIndex:indexPath.row] objectForKey:@"phonenumber"] isEqual:[phonenumber objectAtIndex:i]]) {
                    if (![[[registeredContectList objectAtIndex:indexPath.row] objectForKey:@"favorite"] isEqual:@""] && ![[[registeredContectList objectAtIndex:indexPath.row] objectForKey:@"favorite"] isEqual:@"0"]) {
                        cell.imageView.image = [UIImage imageNamed:@"favorite.png"];
                    }
                    else    {
                        cell.imageView.image = [UIImage imageNamed:@""];
                    }
                }
            }
        }
    }else{
        if ([contactsArray count]>indexPath.row) {
            NSString *contact_name = [NSString stringWithFormat:@"%@ %@", [contactsArray[indexPath.row] objectForKey:@"firstName"],[contactsArray[indexPath.row] objectForKey:@"lastName"]];
            cell.textLabel.text = contact_name;
        }
    }
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    if (indexPath.section == 0 && [registeredContectList count] > indexPath.row) {
        currentPosition = (int)indexPath.row;
        NSDictionary * temp = [registeredContectList objectAtIndex:indexPath.row];
        if ([[[registeredContectList objectAtIndex:indexPath.row] objectForKey:@"favorite"] isEqual:@"0"] || [[[registeredContectList objectAtIndex:indexPath.row] objectForKey:@"favorite"] isEqual:@""]) {
            setting_Favorite = @"1";
            [self setFavorite:[temp objectForKey:@"contact_id"] phone:[temp objectForKey:@"phonenumber"] email:[temp objectForKey:@"email"] favorite:@"1"];
        }
        else    {
            setting_Favorite = @"0";
            [self setFavorite:[temp objectForKey:@"contact_id"] phone:[temp objectForKey:@"phonenumber"] email:[temp objectForKey:@"email"] favorite:@"0"];
        }
    }
}

#pragma mark - Gesture

- (void) setGesture {
    self.transitions.dynamicTransition.slidingViewController = self.slidingViewController;
    
    NSDictionary *transitionData = self.transitions.all[0];
    id<ECSlidingViewControllerDelegate> transition = transitionData[@"transition"];
    if (transition == (id)[NSNull null]) {
        self.slidingViewController.delegate = nil;
    } else {
        self.slidingViewController.delegate = transition;
    }
    
    NSString *transitionName = transitionData[@"name"];
    if ([transitionName isEqualToString:METransitionNameDynamic]) {
        self.slidingViewController.topViewAnchoredGesture = ECSlidingViewControllerAnchoredGestureTapping | ECSlidingViewControllerAnchoredGestureCustom;
        self.slidingViewController.customAnchoredGestures = @[self.dynamicTransitionPanGesture];
        [self.navigationController.view removeGestureRecognizer:self.slidingViewController.panGesture];
        [self.navigationController.view addGestureRecognizer:self.dynamicTransitionPanGesture];
    } else {
        self.slidingViewController.topViewAnchoredGesture = ECSlidingViewControllerAnchoredGestureTapping | ECSlidingViewControllerAnchoredGesturePanning;
        self.slidingViewController.customAnchoredGestures = @[];
        [self.navigationController.view removeGestureRecognizer:self.dynamicTransitionPanGesture];
        [self.navigationController.view addGestureRecognizer:self.slidingViewController.panGesture];
    }
}

- (void) removeGesture {
    [self.navigationController.view removeGestureRecognizer:self.dynamicTransitionPanGesture];
    [self.navigationController.view removeGestureRecognizer:self.slidingViewController.panGesture];
}

- (UIPanGestureRecognizer *)dynamicTransitionPanGesture {
    if (_dynamicTransitionPanGesture) return _dynamicTransitionPanGesture;
    
    _dynamicTransitionPanGesture = [[UIPanGestureRecognizer alloc] initWithTarget:self.transitions.dynamicTransition action:@selector(handleGesture:)];
    
    return _dynamicTransitionPanGesture;
}

- (void) handleGesture:(UIPanGestureRecognizer *)recognizer {
    [self.transitions.dynamicTransition handlePanGesture:recognizer];
}

- (IBAction)menuButtonTapped:(id)sender {
    [self.slidingViewController anchorTopViewToRightAnimated:YES];
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
