package demo.com.checkout.checkoutdemo;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import demo.com.checkout.checkoutdemo.Adapter;
import android.widget.Button;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.gson.JsonArray;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.MultiFormatWriter;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.journeyapps.barcodescanner.BarcodeEncoder;


import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.lang.reflect.Array;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class InvoiceActivity extends AppCompatActivity {

    String arr1;

    ArrayList<String> ImgUrl= new ArrayList<>();
    RecyclerView recyclerView;
    LinearLayoutManager Manager;
    Adapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_invoice);
        String obj = getIntent().getStringExtra("value1");
        try {
            JSONObject myObject = new JSONObject(obj);
            String myData = (myObject.getString("data"));
            JSONObject myJsObject = new JSONObject(myData);
            TextView code = (TextView) findViewById(R.id.code);
            TextView invoice_no = (TextView) findViewById(R.id.invoice_no);
            TextView reference_no = (TextView) findViewById(R.id.reference_no);
            TextView date = (TextView) findViewById(R.id.date);
            TextView amount = (TextView) findViewById(R.id.amount);
            TextView des = (TextView) findViewById(R.id.description);
            ImageView image_view = (ImageView) findViewById(R.id.image_view);

            invoice_no.setText(myJsObject.getString("bill_code"));
            reference_no.setText(myJsObject.getString("reference_id"));
            date.setText(myJsObject.getString("bill_date"));
            amount.setText(myJsObject.getString("amount"));
            des.setText(myJsObject.getString("description"));

            arr1 = myJsObject.getString("biller_codes");

            JSONArray jsonArray = new JSONArray(arr1);
            String[] strArr = new String[jsonArray.length()];

            for (int i = 0; i < jsonArray.length(); i++) {
                strArr[i] = jsonArray.getString(i);
                ImgUrl.add(strArr[i]);
            }


            String text= myJsObject.getString("payment_url");
            MultiFormatWriter multiFormatWriter = new MultiFormatWriter();
            try {
                BitMatrix bitMatrix = multiFormatWriter.encode(text, BarcodeFormat.QR_CODE,400,400);
                BarcodeEncoder barcodeEncoder = new BarcodeEncoder();
                Bitmap bitmap = barcodeEncoder.createBitmap(bitMatrix);
                image_view.setImageBitmap(bitmap);
            } catch (WriterException e) {
                e.printStackTrace();
            }

            this.recyclerView = (RecyclerView)findViewById(R.id.recyclerView);
            Manager = new LinearLayoutManager(this,LinearLayoutManager.HORIZONTAL,true);
            recyclerView.setLayoutManager(Manager);
            adapter = new Adapter(ImgUrl, this);
            recyclerView.setAdapter(adapter);



            Button button = (Button) findViewById(R.id.button);

            button.setOnClickListener(new View.OnClickListener() {
                public void onClick(View v) {
                    Intent myIntent = new Intent(getBaseContext(), MainActivity.class);
                    startActivity(myIntent);
                }
            });

        } catch (JSONException e) {
            e.printStackTrace();
        }
    }



}
