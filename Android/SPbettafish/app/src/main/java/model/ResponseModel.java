package model;

import com.google.gson.annotations.SerializedName;

public class ResponseModel {

    @SerializedName("status")
    private String status;

    @SerializedName("message")
    private String message;

    // Getter dan Setter untuk status
    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    // Getter dan Setter untuk message
    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
