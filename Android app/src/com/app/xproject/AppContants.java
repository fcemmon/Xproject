package com.app.xproject;

/*import com.google.ads.doubleclick.DfpAdView;*/
import java.util.ArrayList;
import java.util.List;
import android.graphics.Typeface;
import android.widget.TabHost;
import android.widget.TextView;

public class AppContants {

	public static TabHost m_tabHost;

	public static String SERVER_URL = "http://youserv.me/xappapi/services/";
	public static String SEARCH_SERVICE = SERVER_URL + "getservices";

	public static String LIKE_SERVICE = SERVER_URL + "setlike";
	public static String COMMENT_SERVICE = SERVER_URL + "setcomment";
	public static String SERVICE_OFFER = SERVER_URL + "offerservice";
	public static String CONTACTS = SERVER_URL
			+ "getcontacts";
	public static String FAVORITE = SERVER_URL + "setfavorite";
	public static String GET_VIEWERS = SERVER_URL + "getviewers";
	
	public static String user_id;
	public static double latitude;
	public static double longitude;
	
	public static Typeface helvetical_roman;
	
	public static int currentPosition = 0;
	
	public static ArrayList<NormalContactDetail> normalContactList = new ArrayList<NormalContactDetail>();
	public static ArrayList<ContactDetail> serviceContactList = new ArrayList<ContactDetail>();
	
	public static ArrayList<ServiceDetails> services = new ArrayList<ServiceDetails>();
	public static ArrayList<NormalContactDetail> noServiceContacts = new ArrayList<NormalContactDetail>();
	public static ArrayList<ViewerDetail> viewerList = new ArrayList<ViewerDetail>();
	
	public static String address;
	
	public static ArrayList<ServiceImageModel> imageArray = new ArrayList<ServiceImageModel>();
}
