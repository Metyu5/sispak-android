package uigu.sisteminformasi.spbettafish;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

import model.HistoryItem;
import network.ApiService;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;

public class HistoryActivity extends AppCompatActivity {

    private RecyclerView recyclerView;
    private HistoryAdapter historyAdapter;
    private List<HistoryItem> historyList;
    private Button btnKembali;
    private ProgressBar progressBar; // ProgressBar untuk loading indikator
    private TextView tvKosong; // TextView untuk pesan jika data kosong

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_history);

        // Inisialisasi RecyclerView
        recyclerView = findViewById(R.id.recyclerViewHistory);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        // Inisialisasi ProgressBar
        progressBar = findViewById(R.id.progressBar);
        progressBar.setVisibility(View.GONE); // Sembunyikan ProgressBar di awal

        // Inisialisasi TextView kosong
        tvKosong = findViewById(R.id.tvkosong);

        // Inisialisasi tombol kembali
        btnKembali = findViewById(R.id.btnKembali);

        // Set listener untuk tombol kembali
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Kembali ke DashboardActivity
                Intent intent = new Intent(HistoryActivity.this, DashboardActivity.class);
                startActivity(intent);
                finish(); // Menutup HistoryActivity jika tidak ingin kembali ke activity ini
            }
        });

        // Mengambil data dari API
        fetchHistoryData();

        // Menangani padding sesuai dengan sistem bar
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
    }

    // Fungsi untuk mengambil data history dari server menggunakan Retrofit
    private void fetchHistoryData() {
        progressBar.setVisibility(View.VISIBLE); // Tampilkan ProgressBar saat memulai pengambilan data

        Retrofit retrofit = RetrofitClient.getInstance();
        ApiService apiService = retrofit.create(ApiService.class);

        Call<List<HistoryItem>> call = apiService.getHistory();
        call.enqueue(new Callback<List<HistoryItem>>() {
            @Override
            public void onResponse(Call<List<HistoryItem>> call, Response<List<HistoryItem>> response) {
                progressBar.setVisibility(View.GONE); // Sembunyikan ProgressBar setelah data berhasil diambil

                if (response.isSuccessful() && response.body() != null) {
                    historyList = response.body();

                    if (historyList != null && !historyList.isEmpty()) {
                        // Jika data ada, tampilkan RecyclerView dan sembunyikan pesan kosong
                        tvKosong.setVisibility(View.GONE);
                        recyclerView.setVisibility(View.VISIBLE);
                        historyAdapter = new HistoryAdapter(HistoryActivity.this, historyList);
                        recyclerView.setAdapter(historyAdapter);
                    } else {
                        // Jika data kosong, tampilkan pesan kosong
                        tvKosong.setVisibility(View.VISIBLE);
                        recyclerView.setVisibility(View.GONE);
                    }
                } else {
                    // Log response error untuk informasi lebih lanjut
                    Log.e("API Error", "Response error: " + response.code());
                    Toast.makeText(HistoryActivity.this, "Data tidak ditemukan", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<List<HistoryItem>> call, Throwable t) {
                progressBar.setVisibility(View.GONE); // Sembunyikan ProgressBar jika terjadi kegagalan
                // Log error saat gagal
                Log.e("API Failure", "Error: " + t.getMessage());
                Toast.makeText(HistoryActivity.this, "Gagal mengambil data", Toast.LENGTH_SHORT).show();
            }
        });
    }
}
