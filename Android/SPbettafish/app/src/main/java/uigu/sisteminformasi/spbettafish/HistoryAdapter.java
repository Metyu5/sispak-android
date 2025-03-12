package uigu.sisteminformasi.spbettafish;

import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.lang.reflect.Type;
import java.util.List;
import java.util.Map;

import model.HistoryItem;

public class HistoryAdapter extends RecyclerView.Adapter<HistoryAdapter.HistoryViewHolder> {

    private Context context;
    private List<HistoryItem> historyList;

    public HistoryAdapter(Context context, List<HistoryItem> historyList) {
        this.context = context;
        this.historyList = historyList;
    }

    @Override
    public HistoryViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.item_history, parent, false);
        return new HistoryViewHolder(view);
    }

    @Override
    public void onBindViewHolder(HistoryViewHolder holder, int position) {
        HistoryItem item = historyList.get(position);

        // Menampilkan nama penyakit dan tanggal diagnosa
        holder.tvPenyakit.setText("Nama Penyakit: " + item.getPenyakit());
        holder.tvTanggal.setText("Tanggal Diagnosa: " + item.getTanggal());
        holder.tvHasilDiagnosa.setText("Hasil Diagnosa: " + item.getHasilDiagnosa());

        // Mengonversi gejala_kategori dari string JSON menjadi Map
        String gejalaKategoriJson = item.getGejalaKategori(); // Dapatkan string JSON
        Gson gson = new Gson();
        Type type = new TypeToken<Map<String, String>>(){}.getType();
        Map<String, String> gejalaMap = gson.fromJson(gejalaKategoriJson, type);

        // Tambahkan log untuk memeriksa apakah gejalaMap sudah terisi dengan benar
        Log.d("HistoryAdapter", "Gejala Map: " + gejalaMap);

        // Jika gejalaMap tidak kosong, tampilkan data gejala
        if (gejalaMap != null && !gejalaMap.isEmpty()) {
            StringBuilder gejalaBuilder = new StringBuilder();
            for (Map.Entry<String, String> entry : gejalaMap.entrySet()) {
                gejalaBuilder.append(entry.getKey()).append(" : ").append(entry.getValue()).append("\n");
            }
            holder.tvGejala.setText("Gejala dan Kategori:\n" + gejalaBuilder.toString());
        } else {
            holder.tvGejala.setText("Gejala dan Kategori: Data tidak tersedia");
        }
    }

    @Override
    public int getItemCount() {
        return historyList.size();
    }

    public static class HistoryViewHolder extends RecyclerView.ViewHolder {
        TextView tvPenyakit, tvTanggal, tvGejala, tvHasilDiagnosa;

        public HistoryViewHolder(View itemView) {
            super(itemView);
            tvPenyakit = itemView.findViewById(R.id.tvPenyakit);
            tvTanggal = itemView.findViewById(R.id.tvTanggal);
            tvGejala = itemView.findViewById(R.id.tvGejala);
            tvHasilDiagnosa = itemView.findViewById(R.id.tvHasilDiagnosa);
        }
    }
}
