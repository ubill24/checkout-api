package demo.com.checkout.checkoutdemo;

import android.content.Intent;
import android.support.design.widget.TextInputEditText;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.AppCompatButton;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import com.androidnetworking.AndroidNetworking;
import com.google.gson.Gson;

import demo.com.checkout.checkoutdemo.sevies.ServiceGenerator;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {

    TextInputEditText amount;
    private APIService mAPIService;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        TextInputEditText api_tokenEt = (TextInputEditText) findViewById(R.id.api);
        final TextInputEditText amountEt = (TextInputEditText) findViewById(R.id.amounts);
        final TextInputEditText currencyEt = (TextInputEditText) findViewById(R.id.currencys);
        final TextInputEditText descriptionEt = (TextInputEditText) findViewById(R.id.descriptions);
        api_tokenEt.setText("a8024ffe355342ef890fcebed5ad3009");
        amountEt.setText("100");
        currencyEt.setText("USD");
        descriptionEt.setText("Check out description");

        AppCompatButton button = (AppCompatButton) findViewById(R.id.btn_check);

        AndroidNetworking.initialize(getApplicationContext());

        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Integer amount = Integer.valueOf(amountEt.getText().toString());
                String currency = currencyEt.getText().toString().trim();
                String description = descriptionEt.getText().toString().trim();

                Post post = new Post(description, currency, amount, "Test", true);
                mAPIService = ServiceGenerator.createService(APIService.class);
                Call<PostResponse<Post>> call = mAPIService.savePost(post);
                call.enqueue(new Callback<PostResponse<Post>>() {
                    @Override
                    public void onResponse(Call<PostResponse<Post>> call, Response<PostResponse<Post>> response) {
                        String url = response.body().getData().getPayment_url();
                              if(!(url == "")){
                                  Intent myIntent = new Intent(getBaseContext(), WebViewActivity.class);
                                  myIntent.putExtra("value1",url);
                                  startActivity(myIntent);
                              }
                    }
                    @Override
                    public void onFailure(Call<PostResponse<Post>> call, Throwable t) {
                        Log.d("FAil", "FAil.");
                    }
                });
            }
        });
    }
}