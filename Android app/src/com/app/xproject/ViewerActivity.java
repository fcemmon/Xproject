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

import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.GoogleMap;

import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.GridView;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.AdapterView.OnItemSelectedListener;

public class ViewerActivity extends ActionBarActivity {

	GoogleMap googleMap;
	private LocationRequest mLocationRequest;
	ViewerViewAdapter adapter;
	GridView viewerList;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_viewer);
	
		Spinner menu = (Spinner)findViewById(R.id.menu_viewer);
		
		viewerList = (GridView)findViewById(R.id.viewerList);
		
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
					startActivity(new Intent(ViewerActivity.this, HomeActivity.class));
					break;
				case 2:
					startActivity(new Intent(ViewerActivity.this, CreateServiceActivity.class));
					break;
				case 3:
					startActivity(new Intent(ViewerActivity.this, ContactActivity.class));
					break;
				case 4:
					startActivity(new Intent(ViewerActivity.this, ViewerActivity.class));
					break;
				}
		    }

		    @Override
		    public void onNothingSelected(AdapterView<?> parentView) {
		        // your code here
		    }

		});
        
        getViewer();
	}

	public void getViewer() {
		ArrayList<NameValuePair> postParam = new ArrayList<NameValuePair>();
		postParam.add(new BasicNameValuePair("user_id", AppContants.user_id));
		new GetViewerTask(AppContants.GET_VIEWERS, "POST", postParam);
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
			startActivity(new Intent(ViewerActivity.this, HomeActivity.class));
			return true;
		}
		else if(id == R.id.action_CreateService)	{
			startActivity(new Intent(ViewerActivity.this, CreateServiceActivity.class));
			return true;
		}
		else if(id == R.id.action_Contact)	{
			startActivity(new Intent(ViewerActivity.this, ContactActivity.class));
			return true;
		}
		else if(id == R.id.action_Viewer)	{
			return true;
		}
		return super.onOptionsItemSelected(item);
	}
	
	public class GetViewerTask extends AsyncTask<String, String, JSONObject>{
	    List<NameValuePair> postparams= new ArrayList<NameValuePair>();
	    String URL=null;
	    String method = null;
	    String jsonrespone = "";
	    ProgressDialog pd1;
	    
	    public GetViewerTask(String url, String method, List<NameValuePair> params) {
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
    	  		AppContants.viewerList = new ArrayList<ViewerDetail>();
    	  		JSONArray data = paramString.getJSONArray("viewers");
    	  		for(int i = 0; i < data.length(); i ++)	{
    	  			JSONObject tempJSON = data.getJSONObject(i);
    	  			ViewerDetail temp = new ViewerDetail();
    	  			temp.viewer_id = tempJSON.getString("viewer_id");
    	  			temp.viewer_name = tempJSON.getString("viewer_name");
    	  			temp.photo = tempJSON.getString("photo");
    	  			temp.service_name = tempJSON.getString("service_name");
    	  			temp.latitude = tempJSON.getString("latitude");
    	  			temp.longitude = tempJSON.getString("longitude");
    	  			AppContants.viewerList.add(temp);
    	  		}
    	  		
    	  		adapter = new ViewerViewAdapter(ViewerActivity.this);
    	  		viewerList.setAdapter(adapter);
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
    	this.pd1 = ProgressDialog.show(ViewerActivity.this, "", "Loading In..", true);
    	super.onPreExecute();
    	}
	}
}
