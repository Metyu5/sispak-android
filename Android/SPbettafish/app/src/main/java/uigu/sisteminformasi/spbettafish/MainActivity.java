package uigu.sisteminformasi.spbettafish;

import android.animation.ObjectAnimator;
import android.animation.AnimatorSet;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);

        // Menyesuaikan padding untuk sistem bar
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        // Tombol untuk pindah ke Register Activity
        Button btn1 = findViewById(R.id.btn1);
        btn1.setOnClickListener(view -> {
            // Menambahkan animasi pantulan (Bounce)
            ObjectAnimator bounce = ObjectAnimator.ofFloat(view, "translationY", 5f, -5f, 5f);
            bounce.setDuration(500);  // Durasi animasi pantulan
            bounce.start();

            // Handler untuk memberikan delay sebelum pindah halaman
            new Handler().postDelayed(() -> {
                // Intent untuk membuka Register Activity
                Intent intent = new Intent(MainActivity.this, RegisterActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NO_HISTORY);
                startActivity(intent);

                // Efek transisi smooth
                overridePendingTransition(android.R.anim.slide_in_left, android.R.anim.slide_out_right);
            }, 500); // Delay selama 500ms agar animasi selesai
        });
    }

    @Override
    public void onBackPressed() {
        // Tampilkan dialog konfirmasi untuk keluar aplikasi
        new AlertDialog.Builder(this)
                .setTitle("Konfirmasi Keluar")
                .setMessage("Apakah Anda yakin ingin keluar?")
                .setPositiveButton("Ya", (dialogInterface, i) -> finishAffinity())
                .setNegativeButton("Tidak", (dialogInterface, i) -> dialogInterface.dismiss())
                .show();
    }
}
