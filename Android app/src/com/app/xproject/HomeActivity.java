package com.app.xproject;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

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

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.animation.OvershootInterpolator;
import android.view.animation.ScaleAnimation;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.SearchView.OnCloseListener;
import android.widget.SearchView.OnQueryTextListener;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.app.xproject.DownloadImageTask.DoneImageDownload;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.GoogleApiClient.ConnectionCallbacks;
import com.google.android.gms.common.api.GoogleApiClient.OnConnectionFailedListener;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.koushikdutta.urlimageviewhelper.UrlImageViewCallback;
import com.koushikdutta.urlimageviewhelper.UrlImageViewHelper;

public class HomeActivity extends ActionBarActivity implements OnItemClickListener, ConnectionCallbacks, OnConnectionFailedListener, OnQueryTextListener, OnCloseListener, LocationListener, DoneImageDownload  {

	ServiceItemRow adapter;
	ListView serviceListView;
	private GoogleApiClient mGoogleApiClient;
	public static final String TAG = HomeActivity.class.getSimpleName();
	private final static int CONNECTION_FAILURE_RESOLUTION_REQUEST = 9000;
	private final static int PLAY_SERVICES_RESOLUTION_REQUEST = 1000;
	
    //Similarly we Create a String Resource for the name and email in the header view
    //And we also create a int resource for profile picture in the header view
 
	GoogleMap googleMap;
	TextView serviceId, serviceDes;
	Button like_bt, comment_bt, skip_bt;
	ImageView serviceThumb;
	LocationManager mLocationManager;
	boolean isHasService;
	Spinner menu;
	String provider;
	private boolean mRequestingLocationUpdates = false;
    private LocationRequest mLocationRequest;
	SearchView searchView;
	
	private static int UPDATE_INTERVAL = 10000; // 10 sec
    private static int FATEST_INTERVAL = 5000; // 5 sec
    private static int DISPLACEMENT = 10; // 10 meters
	
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);
        
		serviceListView = (ListView)findViewById(R.id.serviceList);
		
		menu = (Spinner)findViewById(R.id.menu_home);
		
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
				case 1:startActivity(new Intent(HomeActivity.this, HomeActivity.class));
					break;
				case 2:
					startActivity(new Intent(HomeActivity.this, CreateServiceActivity.class));
					break;
				case 3:
					startActivity(new Intent(HomeActivity.this, ContactActivity.class));
					break;
				case 4:
					startActivity(new Intent(HomeActivity.this, ViewerActivity.class));
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
		
		searchView = (SearchView)findViewById(R.id.searchView1);
		searchView.setIconifiedByDefault(true);
        searchView.setOnQueryTextListener(this);
        searchView.setOnCloseListener(this);
        searchView.clearFocus();
	    
	    InputMethodManager imm = (InputMethodManager)getSystemService(
			      Context.INPUT_METHOD_SERVICE);
		imm.hideSoftInputFromWindow(searchView.getWindowToken(), 0);
	            
		serviceId = (TextView)findViewById(R.id.serviceId);
		serviceDes = (TextView)findViewById(R.id.serviceDetail);
		serviceThumb = (ImageView)findViewById(R.id.serviceThumb);
		like_bt = (Button)findViewById(R.id.likeButton);
		like_bt.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if(AppContants.services.size() <= AppContants.currentPosition)
					return;
				ServiceDetails temp = new ServiceDetails();
				temp = AppContants.services.get(AppContants.currentPosition);
				ArrayList<NameValuePair> params = new ArrayList<NameValuePair>();
				params.add(new BasicNameValuePair("user_id", AppContants.user_id));
				params.add(new BasicNameValuePair("service_id", temp.service_id));
				if(temp.like_status.equals("") || temp.like_status.equals("0"))
					params.add(new BasicNameValuePair("like", "1"));
				else
					params.add(new BasicNameValuePair("like", "0"));
				new LikeTask(AppContants.LIKE_SERVICE, "POST", params).execute();
			}
		});
		comment_bt = (Button)findViewById(R.id.commentButton);
		skip_bt = (Button)findViewById(R.id.skipButton);
		skip_bt.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				AppContants.currentPosition ++;
				if(AppContants.services.size() > AppContants.currentPosition)
					setServiceDetail();
			}
		});
		
		SupportMapFragment fm = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.googlemap);

        // Getting GoogleMap object from the fragment
        googleMap = fm.getMap();

        // Enabling MyLocation Layer of Google Map
        googleMap.setMyLocationEnabled(true);
		
		if (checkPlayServices()) {
			 
            // Building the GoogleApi client
            buildGoogleApiClient();
        }
    }
    
    @Override
    protected void onStart() {
        super.onStart();
        if (mGoogleApiClient != null) {
            mGoogleApiClient.connect();
        }
    }
    
    private void doMySearch(String query)	{
    	Log.d("searchService", query);
    	
    	List<NameValuePair> postParam = new ArrayList<NameValuePair>();
        String udid = getId();
        postParam.add(new BasicNameValuePair("auth_token", udid));
        postParam.add(new BasicNameValuePair("service_name", query));
        postParam.add(new BasicNameValuePair("latitude", "" + AppContants.latitude));
        postParam.add(new BasicNameValuePair("longitude", "" + AppContants.longitude));
        
        serviceDes.setText("");
        serviceId.setText("");
        serviceThumb.setImageBitmap(null);
        
        new BackGroundTask(AppContants.SEARCH_SERVICE, "POST", postParam).execute();
    }
    
    private void getAddress()	{
    	Geocoder geocoder;
    	List<Address> addresses;
    	geocoder = new Geocoder(this, Locale.getDefault());

    	try {
			addresses = geocoder.getFromLocation(AppContants.latitude, AppContants.longitude, 1);
			if(addresses == null || addresses.size() == 0)	{
				AppContants.address = "";
				return;
			}
			String address = addresses.get(0).getAddressLine(0); // If any additional address line present than only, check with max available address lines by getMaxAddressLineIndex()
	    	String city = addresses.get(0).getLocality();
	    	String state = addresses.get(0).getAdminArea();
	    	String country = addresses.get(0).getCountryName();
	    	String postalCode = addresses.get(0).getPostalCode();
	    	String knownName = addresses.get(0).getFeatureName();
	    	
	    	AppContants.address = address;
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} // Here 1 represent max location result to returned, by documents it recommended 1 to 5
    }
    
    private boolean checkPlayServices() {
        int resultCode = GooglePlayServicesUtil
                .isGooglePlayServicesAvailable(this);
        if (resultCode != ConnectionResult.SUCCESS) {
            if (GooglePlayServicesUtil.isUserRecoverableError(resultCode)) {
                GooglePlayServicesUtil.getErrorDialog(resultCode, this,
                        PLAY_SERVICES_RESOLUTION_REQUEST).show();
            } else {
                Toast.makeText(getApplicationContext(),
                        "This device is not supported.", Toast.LENGTH_LONG)
                        .show();
            }
            return false;
        }
        return true;
    }
    
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    protected synchronized void buildGoogleApiClient() {
        mGoogleApiClient = new GoogleApiClient.Builder(this)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(this)
                .addApi(LocationServices.API).build();
    }
    
    protected void createLocationRequest() {
        mLocationRequest = new LocationRequest();
        mLocationRequest.setInterval(UPDATE_INTERVAL);
        mLocationRequest.setFastestInterval(FATEST_INTERVAL);
        mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        mLocationRequest.setSmallestDisplacement(DISPLACEMENT);
    }
    
    protected void onResume() {
        super.onResume();
        checkPlayServices();
        
        // Resuming the periodic location updates
        if (mGoogleApiClient.isConnected() && mRequestingLocationUpdates) {
            startLocationUpdates();
        }
    }
    
    protected void startLocationUpdates() {
    	 if(mGoogleApiClient == null)
    		 return;
    	 if(mLocationRequest == null)
    		 mLocationRequest = LocationRequest.create()
	            .setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY)
	            .setInterval(10 * 1000)        // 10 seconds, in milliseconds
	            .setFastestInterval(1 * 1000);
        LocationServices.FusedLocationApi.requestLocationUpdates(
                mGoogleApiClient, mLocationRequest, this);
    }
 
    /**
     * Stopping location updates
     */
    protected void stopLocationUpdates() {
    	if(mGoogleApiClient == null || !mGoogleApiClient.isConnected())
    		return;
        LocationServices.FusedLocationApi.removeLocationUpdates(
                mGoogleApiClient, this);
    }
    
    @Override
    protected void onStop() {
        super.onStop();
        if(mGoogleApiClient == null)	
        	return;
        if (mGoogleApiClient.isConnected()) {
            mGoogleApiClient.disconnect();
        }
    }
 
    @Override
    protected void onPause() {
        super.onPause();
        stopLocationUpdates();
    }
    
    private void handleNewLocation(Location location) {
        Log.d(TAG, location.toString());
        
        double currentLatitude = location.getLatitude();
        double currentLongitude = location.getLongitude();
        
        AppContants.longitude = currentLongitude;
        AppContants.latitude = currentLatitude;
        
        getAddress();
        LatLng latLng = new LatLng(currentLatitude, currentLongitude);

        MarkerOptions options = new MarkerOptions()
            .position(latLng)
            .title("CurrentLocation");
        googleMap.addMarker(options);
        googleMap.moveCamera(CameraUpdateFactory.newLatLng(latLng));
        googleMap.animateCamera(CameraUpdateFactory.zoomTo(10*5));
        
        List<NameValuePair> postParam = new ArrayList<NameValuePair>();
        String udid = getId();
        postParam.add(new BasicNameValuePair("auth_token", udid));
        postParam.add(new BasicNameValuePair("service_name", ""));
        postParam.add(new BasicNameValuePair("latitude", "" + currentLatitude));
        postParam.add(new BasicNameValuePair("longitude", "" + currentLongitude));
        
        new BackGroundTask(AppContants.SEARCH_SERVICE, "POST", postParam).execute();
    }

    private void monitorFillteredService()	{
    	for(int i = 0; i < AppContants.services.size(); i ++)	{
    		ServiceDetails temp = AppContants.services.get(i);
    		MarkerOptions options = new MarkerOptions()
            .position(new LatLng(Double.parseDouble(temp.getLatitude()), Double.parseDouble(temp.getLongtitude())))
            .title(temp.service_name);
    		googleMap.addMarker(options);
    	}
    }
    
    
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
 
        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }
 
        return super.onOptionsItemSelected(item);
    }
 
	public class BackGroundTask extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public BackGroundTask(String url, String method, List<NameValuePair> params) {
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
    	  	Log.d("response", paramString.toString());
    	  	if(paramString.get("status").equals("success"))	{
    	  		AppContants.user_id = paramString.getString("user_id");
    	  		JSONArray serviceJSONArray = paramString.getJSONArray("services");
    	  		
    	  		AppContants.services = new ArrayList<ServiceDetails>();
    	  		
    	  		for(int i = 0; i < serviceJSONArray.length(); i ++)	{
    	  			JSONObject jObj = serviceJSONArray.getJSONObject(i);
    	  			ServiceDetails temp = new ServiceDetails();
    	  			temp.service_id = jObj.getString("service_id");
    	  			temp.latitude = jObj.getString("latitude");
    	  			temp.longtitude = jObj.getString("longitude");
    	  			temp.service_image = jObj.getString("service_image");
    	  			temp.creater_id = jObj.getString("creater_id");
    	  			temp.creater_name = jObj.getString("creater_name");
    	  			temp.like_status = jObj.getString("like");
    	  			temp.comment_status = jObj.getString("comment");
    	  			temp.service_name = jObj.getString("service_name");
    	  			AppContants.services.add(temp);
    	  			Log.d("getService", "Yes");
    	  		}
    	  		
    	  		AppContants.imageArray = new ArrayList<ServiceImageModel>();
    	  		adapter = new ServiceItemRow(HomeActivity.this);
    	  		monitorFillteredService();
    	  		serviceListView.setAdapter(adapter);
    	  		serviceListView.setOnItemClickListener(HomeActivity.this);
    	   	}
      	}
      	catch (Exception localJSONException)
      	{
      		this.pd1.dismiss();
    	  localJSONException.printStackTrace();
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(HomeActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}
	
	public String getId() {
        String id = android.provider.Settings.System.getString(super.getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
        return id;
    }
	
	public void setServiceDetail()	{
		if(AppContants.services.size() > AppContants.currentPosition)	{
			ServiceDetails temp = new ServiceDetails();
			temp = AppContants.services.get(AppContants.currentPosition);
			serviceId.setText(temp.service_id + "  " + temp.service_name);
			serviceDes.setText(String.format("This service was made by %s", temp.creater_name));
			UrlImageViewHelper.setUrlDrawable(serviceThumb, temp.service_image, R.drawable.userprofile, new UrlImageViewCallback() {
				@Override
				public void onLoaded(ImageView imageView, Bitmap loadedBitmap,
						String url, boolean loadedFromCache) {
					// TODO Auto-generated method stub
					if (!loadedFromCache) {
						ScaleAnimation scale = new ScaleAnimation(0, 1, 0, 1, ScaleAnimation.RELATIVE_TO_SELF, .5f, ScaleAnimation.RELATIVE_TO_SELF, .5f);
				        scale.setDuration(300);
				        scale.setInterpolator(new OvershootInterpolator());
				        imageView.startAnimation(scale);
					}
				}
			});
			isHasService = true;
		}
		else
			isHasService = false;
	}
	
	public class LikeTask extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public LikeTask(String url, String method, List<NameValuePair> params) {
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
      	this.pd1.dismiss();
      	try
      	{ 	
    	  	if(paramString.get("status").equals("success"))	{
    	  		
    	   	}
      	}
      	catch (Exception localJSONException)
      	{
    	  localJSONException.printStackTrace();
    	  if (this.pd1.isShowing()) 
    		  this.pd1.dismiss();
      	} 
    	}
    
    	@Override
    	protected void onPreExecute()
    	{
    	this.pd1 = ProgressDialog.show(HomeActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}

	@Override
	public void onItemClick(AdapterView<?> parent, View view, int position,
			long id) {
		// TODO Auto-generated method stub
		if(AppContants.services.size() <= position)
			return;
		AppContants.currentPosition = position;
		setServiceDetail();
	}

	@Override
	public void onConnectionFailed(ConnectionResult arg0) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onConnected(Bundle arg0) {
		// TODO Auto-generated method stub
		if(mGoogleApiClient == null)
			return;
		Location mLastLocation = LocationServices.FusedLocationApi.getLastLocation(
                mGoogleApiClient);
        if (mLastLocation != null) {
        	handleNewLocation(mLastLocation);
        }
	}

	@Override
	public void onConnectionSuspended(int arg0) {
		// TODO Auto-generated method stub
		if(mGoogleApiClient == null)
			return;
		mGoogleApiClient.connect();
	}

	@Override
	public boolean onClose() {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public boolean onQueryTextSubmit(String query) {
		// TODO Auto-generated method stub
	    searchView.clearFocus();
		doMySearch(query);
		return false;
	}

	@Override
	public boolean onQueryTextChange(String newText) {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public void onLocationChanged(Location arg0) {
		// TODO Auto-generated method stub
		 
        Toast.makeText(getApplicationContext(), "Location changed!",
                Toast.LENGTH_SHORT).show();
 
        // Displaying the new location on UI
        if(arg0 == null)
        	return;
        handleNewLocation(arg0);
	}

	@Override
	public void onDoneImageDownload(boolean isDownload) {
		// TODO Auto-generated method stub
		adapter = new ServiceItemRow(HomeActivity.this);
  		monitorFillteredService();
  		serviceListView.setAdapter(adapter);
  		serviceListView.setOnItemClickListener(HomeActivity.this);
	}
}