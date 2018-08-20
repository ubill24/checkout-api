package demo.com.checkout.checkoutdemo;

        import retrofit2.Call;
        import retrofit2.http.Body;
        import retrofit2.http.POST;

public interface APIService {

    @POST("transaction/init")
    Call<PostResponse<Post>> savePost(@Body Post post);
}
