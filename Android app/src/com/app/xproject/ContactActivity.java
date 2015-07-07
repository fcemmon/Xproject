package com.app.xproject;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONObject;
import org.w3c.dom.Comment;

import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.GoogleMap;

import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.telephony.TelephonyManager;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.provider.ContactsContract.CommonDataKinds.Phone;
import android.provider.ContactsContract.Data;
import android.provider.ContactsContract.PhoneLookup;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemSelectedListener;

public class ContactActivity extends ActionBarActivity implements OnItemClickListener {

	GoogleMap googleMap;
	private LocationRequest mLocationRequest;
	ListView commonContactList, favoriteContactList;
	ArrayList<String> phonenumbers;
	FavoriteItemAdapter adapter;
	private NoServiceItemAdapter listAdapter ;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_contact);
	
		Spinner menu = (Spinner)findViewById(R.id.menu_contact);
		phonenumbers = new ArrayList<String>();
		List<String> list = new ArrayList<String>();
		list.add("Menu");
        list.add("Home");
        list.add("Create Service");
        list.add("Contact");
        list.add("Viewer");
         
        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>
                     (this, android.R.layout.simple_spinner_item,list);
                      
        dataAdapter.setDropDownViewResource
                     (android.R.layout.simple_spinner_dropdown_item);
        
        menu.setAdapter(dataAdapter);
		menu.setOnItemSelectedListener(new OnItemSelectedListener() {
		    @Override
		    public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
		        // your code here
		    	switch (position) {
		    	case 1:
					startActivity(new Intent(ContactActivity.this, HomeActivity.class));
					break;
				case 2:
					startActivity(new Intent(ContactActivity.this, CreateServiceActivity.class));
					break;
				case 3:
					startActivity(new Intent(ContactActivity.this, ContactActivity.class));
					break;
				case 4:
					startActivity(new Intent(ContactActivity.this, ViewerActivity.class));
					break;

				default:
					break;
				}
		    }

		    @Override
		    public void onNothingSelected(AdapterView<?> parentView) {
		        // your code here
		    }

		});
			commonContactList = (ListView)findViewById(R.id.commonContactList);
			favoriteContactList = (ListView)findViewById(R.id.favoriteContactList);
			
			getContactList();
	}
	
	public void  getContactList() {
		AppContants.normalContactList = new ArrayList<NormalContactDetail>();

        Uri contactUri = ContactsContract.Contacts.CONTENT_URI;
        String[] PROJECTION = new String[] {
                ContactsContract.Contacts._ID,
                ContactsContract.Contacts.DISPLAY_NAME,
                ContactsContract.Contacts.HAS_PHONE_NUMBER,
        };
        String SELECTION = ContactsContract.Contacts.HAS_PHONE_NUMBER + "='1'";
        Cursor contacts = getContentResolver().query(ContactsContract.Contacts.CONTENT_URI, PROJECTION, SELECTION, null, null);

        if(contacts == null)
        	return;
        
        if (contacts.getCount() > 0)
        {
            while(contacts.moveToNext()) {
                NormalContactDetail aContact = new NormalContactDetail();
                int idFieldColumnIndex = 0;
                int nameFieldColumnIndex = 0;
                int numberFieldColumnIndex = 0;

                String contactId = contacts.getString(contacts.getColumnIndex(ContactsContract.Contacts._ID));

                nameFieldColumnIndex = contacts.getColumnIndex(PhoneLookup.DISPLAY_NAME);
                if (nameFieldColumnIndex > -1)
                {
                    aContact.contactName = contacts.getString(nameFieldColumnIndex);
                }

                PROJECTION = new String[] {Phone.NUMBER};
                final Cursor phone = managedQuery(Phone.CONTENT_URI, PROJECTION, Data.CONTACT_ID + "=?", new String[]{String.valueOf(contactId)}, null);
                if(phone.moveToFirst()) {
                    while(!phone.isAfterLast())
                    {
                        numberFieldColumnIndex = phone.getColumnIndex(Phone.NUMBER);
                        if (numberFieldColumnIndex > -1)
                        {
                            aContact.phoneNumber = phone.getString(numberFieldColumnIndex);
                            phonenumbers.add(aContact.phoneNumber);
                            phone.moveToNext();
                            TelephonyManager mTelephonyMgr;
                            mTelephonyMgr = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
                            if (!mTelephonyMgr.getLine1Number().contains(aContact.getPhoneNumber()))
                            {
                                AppContants.normalContactList.add(aContact);  
                            }
                        }
                    }
                }
                phone.close();
            }
            
            contacts.close();
            ArrayList<NameValuePair> postParam = new ArrayList<NameValuePair>();
            postParam.add(new BasicNameValuePair("user_id", AppContants.user_id));
            postParam.add(new BasicNameValuePair("phonenumbers", phonenumbers.toString()));
            new GetServiceContact(AppContants.CONTACTS, "POST", postParam).execute();
        }
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_home) {
			startActivity(new Intent(ContactActivity.this, HomeActivity.class));
			return true;
		}
		else if(id == R.id.action_CreateService)	{
			startActivity(new Intent(ContactActivity.this, CreateServiceActivity.class));
			return true;
		}
		else if(id == R.id.action_Contact)	{
			return true;
		}
		else if(id == R.id.action_Viewer)	{
			startActivity(new Intent(ContactActivity.this, ViewerActivity.class));
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	public class GetServiceContact extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public GetServiceContact(String url, String method, List<NameValuePair> params) {
        	URL=url;
        	postparams=params;
        	this.method = method;
    	}
    	@Override
    	protected JSONObject doInBackground(String... params) {
        	// TODO Auto-generated method stub
        	// Making HTTP request
    		InputStream is;
    		JSONObject jObj;
    		String json;
        	try {
        	// Making HTTP request 
        	// check for request method
     
        	if(method.equals("POST")){
            	// request method is POST
            	// defaultHttpClient
        		HttpClient httpClient = new DefaultHttpClient();
            	HttpPost httpPost = new HttpPost(URL);
            	httpPost.setEntity(new UrlEncodedFormEntity(postparams));
            	HttpResponse response = httpClient.execute(httpPost); 
            	HttpEntity entity = response.getEntity();
            	json = EntityUtils.toString(entity);
            	Log.d("Http Response:", response.toString());
            	jObj = new JSONObject(json);
            	return jObj;        
      		}
        }
        catch (Exception e) {             
        	e.printStackTrace();

    	}
        	return null;
    	}
    
    	@Override
    	protected void onPostExecute(JSONObject paramString)
    	{
    	super.onPostExecute(paramString);
      	System.out.println("getServices " + paramString);
      	try
      	{
    	  	this.pd1.dismiss();
    	  	if(paramString.get("status").equals("success"))	{
    	  		AppContants.serviceContactList = new ArrayList<ContactDetail>();
    	  		JSONArray contacts = paramString.getJSONArray("contacts");
    	  		for (int i = 0; i < contacts.length(); i ++)	{
    	  			JSONObject contact = contacts.getJSONObject(i);
    	  			ContactDetail temp = new ContactDetail();
    	  			temp.contactName = contact.getString("contact_name");
    	  			temp.contactID = contact.getString("contact_id");
    	  			temp.favorite = contact.getString("favorite");
    	  			temp.phoneNumber = contact.getString("phonenumber");
    	  			AppContants.serviceContactList.add(temp);
    	  		}
    	  		
    	  		AppContants.noServiceContacts = new ArrayList<NormalContactDetail>();
        	  	
        	  	for (int i = 0; i < AppContants.serviceContactList.size(); i ++)	{
        	  		ContactDetail temp = new ContactDetail();
        	  		temp = AppContants.serviceContactList.get(i);
        	  		for (int j = 0; j < AppContants.normalContactList.size(); j++)	{
        	  			NormalContactDetail normalTemp = new NormalContactDetail();
        	  			if(!temp.phoneNumber.equals(normalTemp.phoneNumber))	{
        	  				AppContants.noServiceContacts.add(normalTemp);
        	  			}
        	  		}
        	  	}    	  	
        	  	adapter = new FavoriteItemAdapter(ContactActivity.this);
        	  	favoriteContactList.setAdapter(adapter);
        	  	favoriteContactList.setOnItemClickListener(ContactActivity.this);
        	  	listAdapter = new NoServiceItemAdapter(ContactActivity.this);
        	  	commonContactList.setAdapter(listAdapter);
    	   	}
      	}
      	catch (Exception localJSONException)
      	{
      		this.pd1.dismiss();
    	  localJSONException.printStackTrace();
    	  if (AppContants.normalContactList.size() == 0) {
			 return;
    	  }
    	  AppContants.noServiceContacts = AppContants.normalContactList;
    	  listAdapter = new NoServiceItemAdapter(ContactActivity.this);
  	  		commonContactList.setAdapter(listAdapter);
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(ContactActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}
	
	public class SetFavoriteTask extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public SetFavoriteTask(String url, String method, List<NameValuePair> params) {
        	URL=url;
        	postparams=params;
        	this.method = method;
    	}
    	@Override
    	protected JSONObject doInBackground(String... params) {
        	// TODO Auto-generated method stub
        	// Making HTTP request
    		InputStream is;
    		JSONObject jObj;
    		String json;
        	try {
        	// Making HTTP request 
        	// check for request method
     
        	if(method.equals("POST")){
            	// request method is POST
            	// defaultHttpClient
        		HttpClient httpClient = new DefaultHttpClient();
            	HttpPost httpPost = new HttpPost(URL);
            	httpPost.setEntity(new UrlEncodedFormEntity(postparams));
            	HttpResponse response = httpClient.execute(httpPost); 
            	HttpEntity entity = response.getEntity();
            	json = EntityUtils.toString(entity);
            	Log.d("Http Response:", response.toString());
            	jObj = new JSONObject(json);
            	return jObj;        
      		}
        }
        catch (Exception e) {             
        	e.printStackTrace();

    	}
        	return null;
    	}
    
    	@Override
    	protected void onPostExecute(JSONObject paramString)
    	{
    	super.onPostExecute(paramString);
      	System.out.println("getServices " + paramString);
      	try
      	{
    	  	this.pd1.dismiss();
    	  	if(paramString.get("status").equals("success"))	{
    	  		adapter.notifyDataSetChanged();
    	  	}
      	}
      	catch (Exception localJSONException)
      	{
    	  localJSONException.printStackTrace();
    	  this.pd1.dismiss();
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(ContactActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}

	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		ContactDetail temp = new ContactDetail();
		temp = AppContants.serviceContactList.get(position);
		
		ArrayList<NameValuePair> postparam = new ArrayList<NameValuePair>();
		postparam.add(new BasicNameValuePair("user_id", AppContants.user_id));
		postparam.add(new BasicNameValuePair("phonenumber", temp.phoneNumber));
		if(temp.favorite.equals("") || temp.favorite.equals("0"))
			postparam.add(new BasicNameValuePair("favorite", "1"));
		else
			postparam.add(new BasicNameValuePair("favorite", "0"));
		new SetFavoriteTask(AppContants.FAVORITE, "POST", postparam).execute();
	}
}
