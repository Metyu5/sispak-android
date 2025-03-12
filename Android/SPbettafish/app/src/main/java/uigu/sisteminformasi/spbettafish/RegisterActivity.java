package uigu.sisteminformasi.spbettafish;

import android.animation.ObjectAnimator;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class RegisterActivity extends AppCompatActivity {

    private boolean isPasswordVisible1 = false; // Flag untuk Password Field 1
    private boolean isPasswordVisible2 = false; // Flag untuk Password Field 2

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_register);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            View decorView = getWindow().getDecorView();
            int uiOptions = View.SYSTEM_UI_FLAG_LAYOUT_STABLE | View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN;
            decorView.setSystemUiVisibility(uiOptions);
            getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        }

        // Tombol kembali
        ImageView img1 = findViewById(R.id.img1);
        img1.setOnClickListener(view -> {
            Intent intent = new Intent(RegisterActivity.this, MainActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
        });

        // Tombol Sign in dengan efek bounce
        TextView txt7 = findViewById(R.id.txt7);
        txt7.setOnClickListener(view -> {
            // Animasi bounce
            ObjectAnimator animator = ObjectAnimator.ofFloat(txt7, "translationY", 0f, -30f, 0f);
            animator.setDuration(300);
            animator.start();

            Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
        });

        // Password Field 1
        EditText edt3 = findViewById(R.id.edt3);
        ImageView img3 = findViewById(R.id.img3);
        img3.setOnClickListener(view -> {
            if (isPasswordVisible1) {
                edt3.setTransformationMethod(PasswordTransformationMethod.getInstance());
                img3.setImageResource(R.drawable.hide);
                isPasswordVisible1 = false;
            } else {
                edt3.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                img3.setImageResource(R.drawable.eye);
                isPasswordVisible1 = true;
            }
            edt3.setSelection(edt3.getText().length());
        });

        // Password Field 2
        EditText edt4 = findViewById(R.id.edt4);
        ImageView imgTogglePassword2 = findViewById(R.id.img4);
        imgTogglePassword2.setOnClickListener(view -> {
            if (isPasswordVisible2) {
                edt4.setTransformationMethod(PasswordTransformationMethod.getInstance());
                imgTogglePassword2.setImageResource(R.drawable.hide);
                isPasswordVisible2 = false;
            } else {
                edt4.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                imgTogglePassword2.setImageResource(R.drawable.eye);
                isPasswordVisible2 = true;
            }
            edt4.setSelection(edt4.getText().length());
        });

        // Tombol Register dengan efek bounce
        Button btn1 = findViewById(R.id.btn1);
        btn1.setOnClickListener(view -> {
            // Animasi bounce
            ObjectAnimator animator = ObjectAnimator.ofFloat(btn1, "translationY", 0f, -30f, 0f);
            animator.setDuration(300);
            animator.start();

            EditText edt1 = findViewById(R.id.edt1);
            EditText edt2 = findViewById(R.id.edt2);
            String username = edt1.getText().toString();
            String email = edt2.getText().toString();
            String password = edt3.getText().toString();
            String confirmPassword = edt4.getText().toString();

            // Validasi data
            if (username.isEmpty() || email.isEmpty() || password.isEmpty() || confirmPassword.isEmpty()) {
                Toast.makeText(RegisterActivity.this, "Silahkan Lengkapi Data", Toast.LENGTH_SHORT).show();
            } else if (!password.equals(confirmPassword)) {
                Toast.makeText(RegisterActivity.this, "Password Tidak Sesuai", Toast.LENGTH_SHORT).show();
            } else {
                // Kirim data ke server menggunakan AsyncTask
                new RegisterTask().execute(username, email, password);
            }
        });
    }

    // AsyncTask untuk mengirim data ke server
    private class RegisterTask extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            String username = params[0];
            String email = params[1];
            String password = params[2];

            try {
                // URL server yang menerima data
                URL url = new URL("http://192.168.1.100/sistempakar/betta_fish_api/register.php"); // Ganti dengan URL API server Anda
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("POST");
                connection.setDoOutput(true);
                connection.setRequestProperty("Content-Type", "application/x-www-form-urlencoded");

                // Menyusun data yang akan dikirim
                String data = "username=" + username + "&email=" + email + "&password=" + password;

                // Menulis data ke output stream
                OutputStream os = connection.getOutputStream();
                os.write(data.getBytes());
                os.flush();
                os.close();

                // Mendapatkan response dari server
                int responseCode = connection.getResponseCode();

                if (responseCode == HttpURLConnection.HTTP_OK) {
                    return "Registrasi Berhasil!";
                } else {
                    return "Registrasi Gagal!";
                }
            } catch (Exception e) {
                e.printStackTrace();
                return "Error: " + e.getMessage();
            }
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            Toast.makeText(RegisterActivity.this, result, Toast.LENGTH_SHORT).show();

            if ("Registrasi Berhasil!".equals(result)) {
                // Menampilkan notifikasi sukses
                Toast.makeText(RegisterActivity.this, "Registrasi berhasil, silahkan login untuk melanjutkan.", Toast.LENGTH_LONG).show();

                // Pindah ke LoginActivity setelah registrasi berhasil
                Intent intent = new Intent(RegisterActivity.this, LoginActivity.class);
                startActivity(intent);
                overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
            }
        }
    }
}
