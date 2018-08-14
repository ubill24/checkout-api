
package demo.com.checkout.checkoutdemo;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Post {

    @SerializedName("description")
    @Expose
    private String description;

    @SerializedName("currency")
    @Expose
    private String currency;
    @SerializedName("amount")
    @Expose
    private Integer amount;

    @SerializedName("reference_id")
    @Expose
    private String referenceId;

    @SerializedName("webview")
    @Expose
    private Boolean webview;


    public Post(String description, String currency, Integer amount, String referenceId, Boolean webview) {
        this.description = description;
        this.currency = currency;
        this.amount = amount;
        this.referenceId = referenceId;
        this.webview = webview;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getCurrency() {
        return currency;
    }

    public void setCurrency(String currency) {
        this.currency = currency;
    }

    public Integer getAmount() {
        return amount;
    }

    public void setAmount(Integer amount) {
        this.amount = amount;
    }

    public String getReferenceId() {
        return referenceId;
    }

    public void setReferenceId(String referenceId) {
        this.referenceId = referenceId;
    }

    public Boolean getWebview() {
        return webview;
    }

    public void setWebview(Boolean webview) {
        this.webview = webview;
    }
}