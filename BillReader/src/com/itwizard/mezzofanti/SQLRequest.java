package com.itwizard.mezzofanti;

import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ListActivity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.net.Uri;
import android.os.Bundle;
import android.widget.*;
import android.R.layout;
import android.widget.AdapterView.*;
import android.view.*;

import java.util.*;
import org.apache.http.*;
import org.apache.http.client.HttpClient.*;
import org.apache.http.client.*;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import java.io.*;
import org.json.*;
import android.widget.ListView;
import android.view.View.OnClickListener;
import android.content.Intent;
import android.content.Intent;

public class SQLRequest extends ListActivity {
	
	private String _username, _password, _billData, _billName, _email;

	//private final CriticalAltitude 
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN );
        setRequestedOrientation( ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE );
        setContentView(R.layout.scores);
        
        Bundle bundle = this.getIntent().getExtras();
        _billData = bundle.getString("BILLPOSTDATA");
        if( _billData == null ) {
        	_billData = "$0.0";
        }

	    TextView highscore = (TextView)findViewById(R.id.title);
	       
	    Button _submitScore = (Button) findViewById(R.id.submit_button);
		_submitScore.setOnClickListener(new View.OnClickListener() {
	        public void onClick(View v) {
	        	submitBill();
	        }
		});
		
    	String[] array = new String[1];
    	array[0] = _billData;
    	
    	ArrayAdapter adapter = new ArrayAdapter<String>(this, R.layout.list_layout, R.id.text1, array );
    	setListAdapter(adapter);
    	getListView().invalidateViews();
		
		//fetchHighscores();
    }
    
    private void submitBill() {
    	String result = "";
    	final InputStream is = null;
    	final Dialog userDialog = new Dialog(this);

    	userDialog.setContentView(R.layout.dialog);
    	userDialog.setTitle("Enter username and password:");
    	
    	//final EditText password = (EditText)userDialog.findViewById(R.id.password);
    	final EditText username = (EditText)userDialog.findViewById(R.id.username);
    	final EditText billname = (EditText)userDialog.findViewById(R.id.billname);
    	final EditText email = (EditText)userDialog.findViewById(R.id.useremail);
    	//final EditText duedate = (EditText)userDialog.findViewById(R.id.date);
    	final Button submit = (Button)userDialog.findViewById(R.id.submit);

    	submit.setOnClickListener(new View.OnClickListener() {
    		public void onClick(View v) {
    			_username = username.getText().toString();
    			_billName = billname.getText().toString();
    			_email = email.getText().toString();
    			//_password = password.getText().toString();
    			if( _username != null ) {
    				//_username = _username.trim();
    				//_username = _username.replaceAll(" ","");
    				//ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
    				//nameValuePairs.add(new BasicNameValuePair("score",((CriticalAltitude)CriticalAltitude.getInstance()).getHighScore() + ""));
    				//nameValuePairs.add(new BasicNameValuePair("name",name));
	
    				/*try{
		      	        HttpClient httpclient = new DefaultHttpClient();
		      	        HttpPost httppost = new HttpPost( "192.168.11.157/day1/mobile.showPost.php?bill="+_billData+"&name="+_username +"&pass="+_password);
		      	       // httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
		      	        HttpResponse response = httpclient.execute(httppost);
		      	        HttpEntity entity = response.getEntity();
		      	        // is = entity.getContent();
    				}catch(Exception e){
		      	       System.err.println( e.toString() );// Log.e("log_tag", "Error in http connection "+e.toString());
    				}*/
    				
    				Intent myIntent = new Intent(Intent.ACTION_VIEW, Uri.parse("http://192.168.11.157/day2/web_frontend/boilerplate/index.php?bill="+_billData+"&name="+_username+"&billName="+_billName+"&email="+_email));
    				startActivity(myIntent);
    				
			  		fetchBill();
			  		userDialog.dismiss();
    			}
    			
    		}
    	});

    	userDialog.show();

    }
    
    public void onConfigurationChanged(Configuration newConfig) {
    	super.onConfigurationChanged(newConfig);
	}
    
    private void fetchBill() {
    	String result = "";
    	//the year data to send
    	ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
    	//nameValuePairs.add(new BasicNameValuePair("bill","name"));
    	InputStream is = null;
    	
    	//http post
    	try{
    	        HttpClient httpclient = new DefaultHttpClient();
    	        HttpPost httppost = new HttpPost("http://192.168.11.157/day2/mobile/showPost.php?bill=" + _billData + "&name=" + _username);
    	        //httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
    	        HttpResponse response = httpclient.execute(httppost);
    	        HttpEntity entity = null;
    	        if( response != null ) {
    	        	entity = response.getEntity();
    	        }
    	        if( entity != null ) {
    	        	is = entity.getContent();
    	        }
    	}catch(Exception e){
    	       System.err.println( e.toString() );// Log.e("log_tag", "Error in http connection "+e.toString());
    	}
    	
    	if( is != null ) {
    	//convert response to string
	    	try{
	    	        BufferedReader reader = new BufferedReader(new InputStreamReader(is,"iso-8859-1"),8);
	    	        StringBuilder sb = new StringBuilder();
	    	        String line = null;
	    	        while ((line = reader.readLine()) != null) {
	    	                sb.append(line + "\n");
	    	        }
	    	        is.close();
	    	 
	    	        result=sb.toString();
	    	}catch(Exception e){
	    		System.err.println( e.toString() );//Log.e("log_tag", "Error converting result "+e.toString());
	    	}
    	}
	    	 
    	String[] array = new String[1];
    	array[0] = result + "(submitted)";//null;
    	//parse json data if mysql not null, or no response
    	/*if( result.equals("null\n") || result.equals( "" )  ) {
        	array = new String[1];
        	array[0] = " ";
    	} else {
	    	try{
    	        JSONArray jArray = new JSONArray(result);
    	        array = new String[jArray.length()];
    	        for(int i=0;i<jArray.length();i++){
    	                JSONObject json_data = jArray.getJSONObject(i);
    	                array[i] = json_data.getInt("bill") + "		" + json_data.getString("name");
    	        }
	    	} catch (JSONException e){
	    		System.err.println( e.toString() );;
	    	}
    	}*/

    	ArrayAdapter adapter = new ArrayAdapter<String>(this, R.layout.list_layout, R.id.text1, array );
    	setListAdapter(adapter);
    	getListView().invalidateViews();
    }
    
}