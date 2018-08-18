package demo.com.checkout.checkoutdemo;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import org.json.JSONException;
import org.json.JSONObject;

public class InvoiceActivity extends AppCompatActivity {

    Object data;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_invoice);

        String obj = getIntent().getStringExtra("value1");
        try {
            JSONObject myObject = new JSONObject(obj);
            String myData = (myObject.getString("data"));
            JSONObject myJsObject = new JSONObject(myData);

            TextView fee_amount = (TextView) findViewById(R.id.fee_amount);
            TextView total_amount = (TextView) findViewById(R.id.total_amount);
            TextView tran_amount = (TextView) findViewById(R.id.tran_amount);
            TextView currency = (TextView) findViewById(R.id.currency);
            TextView trandate = (TextView) findViewById(R.id.tran_date);

            fee_amount.setText(myJsObject.getString("fee_amount"));
            total_amount.setText(myJsObject.getString("total_amount"));
            tran_amount.setText(myJsObject.getString("tran_amount"));
            currency.setText(myJsObject.getString("currency"));
            trandate.setText(myJsObject.getString("tran_date"));

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
