package uigu.sisteminformasi.spbettafish;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class LoginActivity extends AppCompatActivity {

    private boolean isPasswordVisible = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_login);

        // Mengatur padding untuk window insets
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        // Tombol kembali dengan mengklik img2
        ImageView img2 = findViewById(R.id.img1);
        img2.setOnClickListener(view -> {
            Intent intent = new Intent(LoginActivity.this, RegisterActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
        });

        // Password Field
        EditText edt2 = findViewById(R.id.edt2);
        ImageView img4 = findViewById(R.id.img4);

        img4.setOnClickListener(view -> {
            if (isPasswordVisible) {
                edt2.setTransformationMethod(PasswordTransformationMethod.getInstance());
                img4.setImageResource(R.drawable.hide);
                isPasswordVisible = false;
            } else {
                edt2.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                img4.setImageResource(R.drawable.eye);
                isPasswordVisible = true;
            }
            edt2.setSelection(edt2.getText().length());
        });

        // Button untuk login
        Button btn1 = findViewById(R.id.btn1);
        btn1.setOnClickListener(view -> {
            EditText edtEmail = findViewById(R.id.edt1);
            EditText edtPassword = findViewById(R.id.edt2);
            String email = edtEmail.getText().toString();
            String password = edtPassword.getText().toString();

            if (email.isEmpty() || password.isEmpty()) {
                Toast.makeText(LoginActivity.this, "Email dan Password tidak boleh kosong", Toast.LENGTH_SHORT).show();
            } else {
                new LoginTask().execute(email, password);
            }
        });
    }

    private class LoginTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... params) {
            String email = params[0];
            String password = params[1];

            try {
                URL url = new URL("http://192.168.1.100/sistempakar/betta_fish_api/login.php");
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoOutput(true);
                connection.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");

                String data = "email=" + email + "&password=" + password;
                OutputStream os = connection.getOutputStream();
                os.write(data.getBytes());
                os.flush();
                os.close();

                int responseCode = connection.getResponseCode();

                if (responseCode == HttpURLConnection.HTTP_OK) {
                    BufferedReader in = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                    StringBuilder response = new StringBuilder();
                    String inputLine;
                    while ((inputLine = in.readLine()) != null) {
                        response.append(inputLine);
                    }
                    in.close();

                    return response.toString();
                } else {
                    return "invalid credentials";
                }
            } catch (Exception e) {
                e.printStackTrace();
                return "Error: " + e.getMessage();
            }
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);

            try {
                // Mengecek apakah respons JSON valid
                if (result != null && result.startsWith("{")) {
                    JSONObject jsonResponse = new JSONObject(result);

                    // Jika server mengirimkan "invalid credentials"
                    if (jsonResponse.has("message") && jsonResponse.getString("message").equals("invalid credentials")) {
                        Toast.makeText(LoginActivity.this, "Periksa Kembali Email Dan Password Anda", Toast.LENGTH_SHORT).show();
                    } else {
                        String username = jsonResponse.optString("username", "");
                        String email = jsonResponse.optString("email", "");

                        if (!username.isEmpty()) {
                            // Menyimpan username di SharedPreferences
                            SharedPreferences sharedPreferences = getSharedPreferences("user_data", MODE_PRIVATE);
                            SharedPreferences.Editor editor = sharedPreferences.edit();
                            editor.putString("nama_pengguna", username);  // Menyimpan username
                            editor.apply();  // Menyimpan perubahan

                            Intent intent = new Intent(LoginActivity.this, DashboardActivity.class);
                            intent.putExtra("username", username);
                            Toast.makeText(LoginActivity.this, "Login Sebagai " + username + " Berhasil", Toast.LENGTH_SHORT).show();
                            startActivity(intent);
                            overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
                        } else {
                            Toast.makeText(LoginActivity.this, "Username Tidak Dikenali", Toast.LENGTH_SHORT).show();
                        }
                    }
                } else {
                    // Menangani respons non-JSON (misalnya, server error)
                    Toast.makeText(LoginActivity.this, "Terjadi Kesalahan Pada Server", Toast.LENGTH_SHORT).show();
                }
            } catch (JSONException e) {
                e.printStackTrace();
                Toast.makeText(LoginActivity.this, "Email dan Password Anda Salah", Toast.LENGTH_SHORT).show();
            } catch (Exception e) {
                e.printStackTrace();
                Toast.makeText(LoginActivity.this, "Terjadi Kesalahan Tidak Diketahui", Toast.LENGTH_SHORT).show();
            }
        }

    }
}
