package com.app.xproject;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.mime.HttpMultipartMode;
import org.apache.http.entity.mime.MultipartEntity;
import org.apache.http.entity.mime.content.ByteArrayBody;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.IntentSender;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.Bitmap.CompressFormat;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

public class CreateServiceActivity extends ActionBarActivity implements GoogleApiClient.ConnectionCallbacks, 
GoogleApiClient.OnConnectionFailedListener, LocationListener {

	GoogleMap googleMap;
	SharedPreferences mypref;
	SharedPreferences.Editor myedit;
	private LocationRequest mLocationRequest;
	EditText userName, phoneNumber, email, address, serviceName;
	ImageView userprofile, camera;
	String username_reg, phonenumber_reg, email_reg;
	Button offerButton;
	Bitmap profileImageBitmap;
	private GoogleApiClient mGoogleApiClient;
	public static final String TAG = HomeActivity.class.getSimpleName();
	private final static int CONNECTION_FAILURE_RESOLUTION_REQUEST = 9000;
	private static final int CAMERA_REQUEST = 1888; 
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_createservice);
		
		mypref = getSharedPreferences("Xproject", Activity.MODE_PRIVATE);
		myedit = mypref.edit();
		
		username_reg = mypref.getString("userName", "");
		phonenumber_reg = mypref.getString("phoneNumber", "");
		email_reg = mypref.getString("email", "");
		
		Spinner menu = (Spinner)findViewById(R.id.menu_createservice);
		
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
					startActivity(new Intent(CreateServiceActivity.this, HomeActivity.class));
					break;
				case 2:
					startActivity(new Intent(CreateServiceActivity.this, CreateServiceActivity.class));
					break;
				case 3:
					startActivity(new Intent(CreateServiceActivity.this, ContactActivity.class));
					break;
				case 4:
					startActivity(new Intent(CreateServiceActivity.this, ViewerActivity.class));
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
		
		userName = (EditText)findViewById(R.id.userNameView);
		phoneNumber = (EditText)findViewById(R.id.phoneNumberView);
		email = (EditText)findViewById(R.id.emailVeiew);
		address = (EditText)findViewById(R.id.addressView);
		serviceName = (EditText)findViewById(R.id.serviceName);
		
		userName.setText(username_reg);
		email.setText(email_reg);
		phoneNumber.setText(phonenumber_reg);
		address.setText(AppContants.address);
		
		InputMethodManager imm = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(userName.getWindowToken(), 0);
			
		InputMethodManager imm1 = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(phoneNumber.getWindowToken(), 0);
		
		InputMethodManager imm2 = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(email.getWindowToken(), 0);
		
		InputMethodManager imm3 = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(address.getWindowToken(), 0);
		
		InputMethodManager imm4 = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(serviceName.getWindowToken(), 0);
		
		userprofile = (ImageView)findViewById(R.id.serviceProfileImage);
		camera = (ImageView)findViewById(R.id.camera);
		camera.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Log.d("createPhoto", "Yes");
				Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE); 
                startActivityForResult(cameraIntent, CAMERA_REQUEST); 
			}
		});
		offerButton = (Button)findViewById(R.id.offer);
		offerButton.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Log.d("createPhoto", "No");
				
				InputMethodManager imm = (InputMethodManager)getSystemService(
					      Context.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(userName.getWindowToken(), 0);
					
				InputMethodManager imm1 = (InputMethodManager)getSystemService(
					      Context.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(phoneNumber.getWindowToken(), 0);
				
				InputMethodManager imm2 = (InputMethodManager)getSystemService(
					      Context.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(email.getWindowToken(), 0);
				
				InputMethodManager imm3 = (InputMethodManager)getSystemService(
					      Context.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(address.getWindowToken(), 0);
				
				InputMethodManager imm4 = (InputMethodManager)getSystemService(
					      Context.INPUT_METHOD_SERVICE);
				imm.hideSoftInputFromWindow(serviceName.getWindowToken(), 0);
				
				new UploadImage(AppContants.SERVER_URL + "postimage?user_id=" + AppContants.user_id, "POST").execute();
					
			}
		});
	}
	
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {  
        if (requestCode == CAMERA_REQUEST && resultCode == RESULT_OK) {  
            Bitmap photo = (Bitmap) data.getExtras().get("data"); 
            userprofile.setImageBitmap(photo);
            profileImageBitmap = photo;
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
			startActivity(new Intent(CreateServiceActivity.this, HomeActivity.class));
			return true;
		}
		else if(id == R.id.action_CreateService)	{
			return true;
		}
		else if(id == R.id.action_Contact)	{
			startActivity(new Intent(CreateServiceActivity.this, ContactActivity.class));
			return true;
		}
		else if(id == R.id.action_Viewer)	{
			startActivity(new Intent(CreateServiceActivity.this, ViewerActivity.class));
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	@Override
    protected void onPause() {
        super.onPause();
    }
	
	public void onConnectionFailed(ConnectionResult arg0) {
		// TODO Auto-generated method stub
	}

	@Override
	public void onConnected(Bundle arg0) {
		// TODO Auto-generated method stub
	}

	@Override
	public void onConnectionSuspended(int arg0) {
		// TODO Auto-generated method stub
		
	}
	
	@Override
	public void onLocationChanged(Location location) {
	    handleNewLocation(location);
	    mLocationRequest = LocationRequest.create()
	            .setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY)
	            .setInterval(10 * 1000)        // 10 seconds, in milliseconds
	            .setFastestInterval(1 * 1000); // 1 second, in milliseconds
	}
	
	private void handleNewLocation(Location location) {
    }
	
	public class UploadImage extends AsyncTask<Void, String, JSONObject> 	{
		
		String URL = null;
		String method = null;
		String jsonresponse = "";
		ProgressDialog pd1;
		
		public UploadImage(String url, String method) {
        	URL=url;
        	this.method = method;
    	}
		
		@Override
    	protected JSONObject doInBackground(Void... params) {
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
            	
            	ByteArrayOutputStream bos = new ByteArrayOutputStream();
	            profileImageBitmap.compress(CompressFormat.JPEG, 100, bos);
	            byte[] data = bos.toByteArray();
            	
            	ByteArrayBody bab = new ByteArrayBody(data, "image.jpg");
            	
            	MultipartEntity reqEntity = new MultipartEntity(HttpMultipartMode.BROWSER_COMPATIBLE);
            	reqEntity.addPart("photo", bab);	            
            	httpPost.setEntity(reqEntity);
            	
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
    	  		ArrayList<NameValuePair> postparam = new ArrayList<NameValuePair>();
	            postparam.add(new BasicNameValuePair("user_id", AppContants.user_id));
	            postparam.add(new BasicNameValuePair("user_name", userName.getText().toString()));
	            postparam.add(new BasicNameValuePair("phonenumber", phoneNumber.getText().toString()));
	            postparam.add(new BasicNameValuePair("phone_type", ""));
	            postparam.add(new BasicNameValuePair("email", email.getText().toString()));
	            postparam.add(new BasicNameValuePair("email_type", ""));
	            postparam.add(new BasicNameValuePair("longitude", ""+ AppContants.longitude));
	            postparam.add(new BasicNameValuePair("latitude", "" + AppContants.latitude));
	            postparam.add(new BasicNameValuePair("address", address.getText().toString()));
	            postparam.add(new BasicNameValuePair("address_type", ""));
	            postparam.add(new BasicNameValuePair("service_name", serviceName.getText().toString()));
	            postparam.add(new BasicNameValuePair("photo", paramString.getString("photo_url")));
	            new OfferTask(AppContants.SERVICE_OFFER, "POST", postparam).execute();
    	  	}
      	}
      	catch (Exception localJSONException)
      	{
    	  localJSONException.printStackTrace();
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(CreateServiceActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}
	
	public class OfferTask extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public OfferTask(String url, String method, List<NameValuePair> params) {
        	URL=url;
        	postparams=params;
        	this.method = method;
    	}
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
    	  		myedit.putString("userName", userName.getText().toString());
    	  		myedit.putString("phoneNumber", phoneNumber.getText().toString());
    	  		myedit.putString("email", email.getText().toString());
    	  		myedit.commit();
    	  		
    	  		Toast.makeText(CreateServiceActivity.this, "Service Created", 1);
    	   	}
      	}
      	catch (Exception localJSONException)
      	{
    	  localJSONException.printStackTrace();
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(CreateServiceActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}
}
