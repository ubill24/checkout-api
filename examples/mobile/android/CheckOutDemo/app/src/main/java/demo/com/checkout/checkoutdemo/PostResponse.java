package demo.com.checkout.checkoutdemo;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class PostResponse<E> {
    @SerializedName("message")
    private String message;
    @SerializedName("status")
    private boolean status;
    @SerializedName("code")
    private String code;
    @SerializedName("data")
    @Expose
    private Data data;

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public Data getData() {
        return data;
    }

    public void setData(Data data) {
        this.data = data;
    }

}

 class Data {

    @SerializedName("tran_id")
    @Expose
    private String tranId;
    @SerializedName("payment_url")
    @Expose
    private String payment_url;

    public String getTranId() {
        return tranId;
    }

    public void setTranId(String tranId) {
        this.tranId = tranId;
    }

    public String getPayment_url() {
        return payment_url;
    }

    public void sePayment_url(String bar) {
        this.payment_url = payment_url;
    }

}