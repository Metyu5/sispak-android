package uigu.sisteminformasi.spbettafish;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.text.Spannable;
import android.text.SpannableString;
import android.text.style.ForegroundColorSpan;
import android.text.style.StyleSpan;
import android.graphics.Color;
import android.view.View;
import android.view.animation.AlphaAnimation;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.viewpager2.widget.ViewPager2;

public class DashboardActivity extends AppCompatActivity {

    private int[] images = {R.drawable.image1, R.drawable.image2, R.drawable.image3, R.drawable.image4};
    private String[] texts = {
            "Temukan Solusi Tepat Untuk Permasalahan Kesehatan Ikan Betta Fish Anda",
            "Perawatan Betta Fish yang Mudah dan Efektif",
            "Diagnosa dan Atasi Masalah Kesehatan Ikan Betta Anda dengan Mudah",
            "Jaga kesehatan ikan Betta Anda dengan mudah – mulai sekarang!"
    };
    private LinearLayout dotsContainer;
    private Button buttonDiagnosa;
    private ViewPager2 viewPager;
    private ImageView imgHome, imgHistory, imgLogout, imageView3;
    private TextView txtHome, txtHistory, txtLogout, txtUsername;
    // Inisialisasi ProgressBar
    private ProgressBar progressBar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_dashboard);

        // Menyembunyikan navigation bar dan status bar
        getWindow().getDecorView().setSystemUiVisibility(
                View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY |
                        View.SYSTEM_UI_FLAG_FULLSCREEN |
                        View.SYSTEM_UI_FLAG_HIDE_NAVIGATION
        );

        // Inisialisasi views
        viewPager = findViewById(R.id.viewPager);
        dotsContainer = findViewById(R.id.dotsContainer);
        buttonDiagnosa = findViewById(R.id.buttondiagnosa);
        imgHome = findViewById(R.id.imgHome);
        imgHistory = findViewById(R.id.imgHistory);
        imgLogout = findViewById(R.id.imgLogout);
        txtHome = findViewById(R.id.txtHome);
        txtHistory = findViewById(R.id.txtHistory);
        txtLogout = findViewById(R.id.txtLogout);
        imageView3 = findViewById(R.id.imageView3);
        txtUsername = findViewById(R.id.txtUsername);
        // Inisialisasi ProgressBar
        progressBar = findViewById(R.id.progressBar);



        // Menambahkan animasi fade-in pada tampilan saat awal
        applyFadeInAnimation(buttonDiagnosa);
        applyFadeInAnimation(imgHome);
        applyFadeInAnimation(imgHistory);
        applyFadeInAnimation(imgLogout);
        applyFadeInAnimation(imageView3);
        applyFadeInAnimation(txtHome);
        applyFadeInAnimation(txtHistory);
        applyFadeInAnimation(txtLogout);
        applyFadeInAnimation(txtUsername);

        // Ambil username dari Intent dan tampilkan dengan warna yang berbeda dan bold
        String username = getIntent().getStringExtra("username");
        if (username != null) {
            // Membuat SpannableString untuk memberikan warna pada teks dan membuat bold pada username
            SpannableString spannableString = new SpannableString(username);
            spannableString.setSpan(new ForegroundColorSpan(Color.parseColor("white")), 0, username.length(), Spannable.SPAN_EXCLUSIVE_EXCLUSIVE); // Warna ungu untuk username
            spannableString.setSpan(new StyleSpan(android.graphics.Typeface.BOLD), 0, username.length(), Spannable.SPAN_EXCLUSIVE_EXCLUSIVE); // Membuat username menjadi bold

            txtUsername.setText(spannableString);
        }

        // Set Adapter untuk ViewPager
        ViewPagerAdapter adapter = new ViewPagerAdapter(this, images, texts);
        viewPager.setAdapter(adapter);

        // Add Dots
        addDots(0);

        // Register callback untuk page changes
        viewPager.registerOnPageChangeCallback(new ViewPager2.OnPageChangeCallback() {
            @Override
            public void onPageSelected(int position) {
                addDots(position);
                if (position == images.length - 1) {
                    showButtonWithFadeIn();
                } else {
                    buttonDiagnosa.setVisibility(View.GONE);
                }
                applyFadeInAnimation(position);
            }
        });


        // Tombol Diagnosa, ketika diklik, ProgressBar akan ditampilkan dan navigasi ke DiagnosaActivity
        buttonDiagnosa.setOnClickListener(v -> {
            // Tampilkan ProgressBar sebelum berpindah ke halaman diagnosa
            progressBar.setVisibility(View.VISIBLE);

            // Beri sedikit delay jika ingin memberikan efek loading sebelum berpindah activity
            new Handler().postDelayed(() -> {
                // Pindahkan ke activity Diagnosa
                Intent intent = new Intent(DashboardActivity.this, DiagnosaActivity.class);
                startActivity(intent);
                progressBar.setVisibility(View.GONE);  // Sembunyikan progressBar setelah berpindah
            }, 5000);  // Waktu tunggu (2 detik)
        });

        // Handle History button click
        imgHistory.setOnClickListener(v -> startActivity(new Intent(DashboardActivity.this, HistoryActivity.class)));

        // Handle Logout button click
        imgLogout.setOnClickListener(v -> showLogoutConfirmationDialog());
    }

    // Fungsi untuk menambahkan animasi fade-in pada setiap elemen
    private void applyFadeInAnimation(View view) {
        AlphaAnimation fadeIn = new AlphaAnimation(0f, 1f);
        fadeIn.setDuration(1000);  // Durasi animasi fade-in
        fadeIn.setFillAfter(true); // Memastikan animasi tetap
        view.startAnimation(fadeIn);
    }

    private void applyFadeInAnimation(int position) {
        ImageView currentImage = (ImageView) viewPager.findViewWithTag("page_" + position);
        if (currentImage != null) {
            applyFadeInAnimation(currentImage);
        }
    }
    @Override
    public void onBackPressed() {
        // FUNGSI AGAR NAVIGATION BAWAAN ANDROID DIMATIKAN

    }


    private void showButtonWithFadeIn() {
        buttonDiagnosa.setVisibility(View.VISIBLE);
        AlphaAnimation fadeIn = new AlphaAnimation(0f, 1f);
        fadeIn.setDuration(1000);
        fadeIn.setFillAfter(true);
        buttonDiagnosa.startAnimation(fadeIn);
    }

    private void addDots(int position) {
        dotsContainer.removeAllViews();
        for (int i = 0; i < images.length; i++) {
            ImageView dot = new ImageView(this);
            dot.setImageResource(i == position ? R.drawable.active_dot : R.drawable.inactive_dot);
            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.WRAP_CONTENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            );
            params.setMargins(8, 0, 8, 0);
            dotsContainer.addView(dot, params);
        }
    }

    // Fungsi untuk menampilkan dialog konfirmasi logout
    private void showLogoutConfirmationDialog() {
        // Mengubah teks tombol logout menjadi "Apakah Anda ingin logout?"
        AlertDialog.Builder builder = new AlertDialog.Builder(DashboardActivity.this);
        builder.setTitle("Konfirmasi Logout")
                .setMessage("Apakah Anda ingin logout?")
                .setCancelable(false)  // Mencegah pengguna menutup dialog dengan mengetuk di luar dialog
                .setPositiveButton("Ya", (dialog, id) -> {
                    // Arahkan pengguna ke LoginActivity setelah logout
                    Intent intent = new Intent(DashboardActivity.this, LoginActivity.class);
                    startActivity(intent);
                    finish(); // Menutup DashboardActivity agar tidak bisa kembali ke halaman ini
                })
                .setNegativeButton("Tidak", (dialog, id) -> dialog.dismiss());  // Menutup dialog jika "Tidak" ditekan

        // Menampilkan dialog
        AlertDialog alert = builder.create();
        alert.show();

    }

}