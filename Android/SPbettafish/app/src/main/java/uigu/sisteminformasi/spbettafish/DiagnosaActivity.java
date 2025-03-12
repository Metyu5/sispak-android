package uigu.sisteminformasi.spbettafish;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import network.ApiService;
import model.Penyakit;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class DiagnosaActivity extends AppCompatActivity {

    private RadioGroup radioGroupPenyakit;
    private Button btnDiagnosa;
    private int selectedPenyakitId;  // ID penyakit yang dipilih

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_diagnosa);
        radioGroupPenyakit = findViewById(R.id.radioGroupPenyakit);
        btnDiagnosa = findViewById(R.id.btnDiagnosa);

        // Setup Retrofit untuk memanggil API
        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl("http://192.168.1.100/sistempakar/betta_fish_api/")  // Ganti dengan URL server Anda
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        ApiService apiService = retrofit.create(ApiService.class);

        // Memanggil API untuk mendapatkan daftar penyakit
        Call<List<Penyakit>> call = apiService.getPenyakitList();

        // Menggunakan enqueue untuk menjalankan request secara asynchronous
        call.enqueue(new Callback<List<Penyakit>>() {
            @Override
            public void onResponse(Call<List<Penyakit>> call, Response<List<Penyakit>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    List<Penyakit> penyakitList = response.body();
                    for (Penyakit penyakit : penyakitList) {
                        RadioButton radioButton = new RadioButton(DiagnosaActivity.this);
                        radioButton.setText(penyakit.getNama());
                        radioButton.setId(penyakit.getId());  // ID penyakit sebagai identifier
                        radioGroupPenyakit.addView(radioButton);  // Menambahkan radio button ke RadioGroup
                    }
                } else {
                    Toast.makeText(DiagnosaActivity.this, "Gagal memuat data penyakit", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<List<Penyakit>> call, Throwable t) {
                Toast.makeText(DiagnosaActivity.this, "Gagal terhubung ke server", Toast.LENGTH_SHORT).show();
            }
        });

        // Tombol untuk melanjutkan ke pemilihan gejala
        btnDiagnosa.setOnClickListener(v -> {
            int selectedId = radioGroupPenyakit.getCheckedRadioButtonId();
            if (selectedId != -1) {
                // Ambil nama penyakit yang dipilih
                RadioButton selectedRadioButton = findViewById(selectedId);
                String namaPenyakit = selectedRadioButton.getText().toString();

                // Ambil nama pengguna yang sedang login (misalnya dari SharedPreferences)
                SharedPreferences sharedPreferences = getSharedPreferences("user_data", MODE_PRIVATE);
                String namaPengguna = sharedPreferences.getString("nama_pengguna", "");  // Ambil nama pengguna yang tersimpan


                // Menyimpan nama penyakit dan nama pengguna ke SharedPreferences
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("nama_pengguna", namaPengguna);  // Simpan nama pengguna
                editor.putString("nama_penyakit", namaPenyakit);  // Simpan nama penyakit yang dipilih
                editor.apply();  // Simpan perubahan

                // Lanjutkan ke aktivitas berikutnya (misalnya PilihGejalaActivity)
                Intent intent = new Intent(DiagnosaActivity.this, PilihGejalaActivity.class);
                intent.putExtra("penyakitId", selectedRadioButton.getId());  // Kirim ID penyakit
                startActivity(intent);
            } else {
                Toast.makeText(DiagnosaActivity.this, "Pilih Penyakit terlebih dahulu", Toast.LENGTH_SHORT).show();
            }
        });
    }
}
