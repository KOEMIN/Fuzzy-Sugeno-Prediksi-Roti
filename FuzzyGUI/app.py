import tkinter as tk
from tkinter import messagebox
from tkinter import font as tkfont

# 1. LOGIKA UTAMA FUZZY SUGENO 
class FuzzySugenoService:
    def calculate(self, permintaan, persediaan):
        # Fuzzifikasi Permintaan
        mu_permintaan_kecil = self.permintaan_kecil(permintaan)
        mu_permintaan_sedang = self.permintaan_sedang(permintaan)
        mu_permintaan_besar = self.permintaan_besar(permintaan)

        # Fuzzifikasi Persediaan
        mu_persediaan_sedikit = self.persediaan_sedikit(persediaan)
        mu_persediaan_sedang = self.persediaan_sedang(persediaan)
        mu_persediaan_banyak = self.persediaan_banyak(persediaan)

        z_sedikit, z_sedang, z_banyak = 1996, 2275, 2579

        # Evaluasi Rules (Alpha Predicate)
        rules = [
            {"id": "R1", "desc": "IF Permintaan KECIL AND Persediaan SEDIKIT", "alpha": min(mu_permintaan_kecil, mu_persediaan_sedikit), "z": z_sedikit, "out": "SEDIKIT"},
            {"id": "R2", "desc": "IF Permintaan KECIL AND Persediaan SEDANG", "alpha": min(mu_permintaan_kecil, mu_persediaan_sedang), "z": z_sedikit, "out": "SEDIKIT"},
            {"id": "R3", "desc": "IF Permintaan KECIL AND Persediaan BANYAK", "alpha": min(mu_permintaan_kecil, mu_persediaan_banyak), "z": z_sedikit, "out": "SEDIKIT"},
            {"id": "R4", "desc": "IF Permintaan SEDANG AND Persediaan SEDIKIT", "alpha": min(mu_permintaan_sedang, mu_persediaan_sedikit), "z": z_sedikit, "out": "SEDIKIT"},
            {"id": "R5", "desc": "IF Permintaan SEDANG AND Persediaan SEDANG", "alpha": min(mu_permintaan_sedang, mu_persediaan_sedang), "z": z_sedang, "out": "SEDANG"},
            {"id": "R6", "desc": "IF Permintaan SEDANG AND Persediaan BANYAK", "alpha": min(mu_permintaan_sedang, mu_persediaan_banyak), "z": z_sedang, "out": "SEDANG"},
            {"id": "R7", "desc": "IF Permintaan BESAR AND Persediaan SEDIKIT", "alpha": min(mu_permintaan_besar, mu_persediaan_sedikit), "z": z_sedikit, "out": "SEDIKIT"},
            {"id": "R8", "desc": "IF Permintaan BESAR AND Persediaan SEDANG", "alpha": min(mu_permintaan_besar, mu_persediaan_sedang), "z": z_sedang, "out": "SEDANG"},
            {"id": "R9", "desc": "IF Permintaan BESAR AND Persediaan BANYAK", "alpha": min(mu_permintaan_besar, mu_persediaan_banyak), "z": z_banyak, "out": "BANYAK"},
        ]

        total_alpha_z = sum(item["alpha"] * item["z"] for item in rules)
        total_alpha = sum(item["alpha"] for item in rules)

        if total_alpha == 0:
            return 0.0, rules

        return total_alpha_z / total_alpha, rules

    def permintaan_kecil(self, x):
        if x <= 1030: return 1.0
        if 1030 < x <= 1310: return (1310 - x) / 280
        return 0.0

    def permintaan_sedang(self, x):
        if x <= 1030 or x >= 1589: return 0.0
        if 1030 < x <= 1310: return (x - 1030) / 280
        if 1310 < x < 1589: return (1589 - x) / 279
        return 0.0

    def permintaan_besar(self, x):
        if x <= 1310: return 0.0
        if 1310 < x <= 1589: return (x - 1310) / 279
        return 1.0

    def persediaan_sedikit(self, y):
        if y <= 607: return 1.0
        if 607 < y <= 750: return (750 - y) / 143
        return 0.0

    def persediaan_sedang(self, y):
        if y <= 607 or y >= 894: return 0.0
        if 607 < y <= 750: return (y - 607) / 143
        if 750 < y < 894: return (894 - y) / 144
        return 0.0

    def persediaan_banyak(self, y):
        if y <= 750: return 0.0
        if 750 < y <= 894: return (y - 750) / 144
        return 1.0

# 2. ANTARMUKA / GUI MENGGUNAKAN TKINTER
class FuzzyApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Prediksi Produksi Roti - Fuzzy Sugeno")
        self.root.geometry("620x720")
        self.root.configure(bg="#f1f5f9")
        
        self.service = FuzzySugenoService()

        # Fonts
        self.font_title = tkfont.Font(family="Helvetica", size=15, weight="bold")
        self.font_subtitle = tkfont.Font(family="Helvetica", size=10, weight="normal")
        self.font_section = tkfont.Font(family="Helvetica", size=11, weight="bold")
        self.font_label = tkfont.Font(family="Helvetica", size=10, weight="bold")
        self.font_result = tkfont.Font(family="Helvetica", size=16, weight="bold")
        
        # Colors
        self.bg_primary = "#4f46e5"
        self.bg_accent = "#10b981"
        self.bg_card = "#ffffff"
        self.text_dark = "#1e293b"
        self.text_light = "#ffffff"
        self.text_muted = "#64748b"

        # 1. Header Frame
        header_frame = tk.Frame(root, bg=self.bg_primary)
        header_frame.pack(fill="x", side="top")
        
        lbl_title = tk.Label(header_frame, text="SISTEM PREDIKSI PRODUKSI ROTI", bg=self.bg_primary, fg=self.text_light, font=self.font_title)
        lbl_title.pack(pady=(15, 0))
        
        lbl_subtitle = tk.Label(header_frame, text="Logika Fuzzy Metode Sugeno (Paper Barekeng 2015)", bg=self.bg_primary, fg="#c7d2fe", font=self.font_subtitle)
        lbl_subtitle.pack(pady=(0, 15))

        # 2. Main Container
        container = tk.Frame(root, bg="#f1f5f9", padx=15, pady=10)
        container.pack(fill="both", expand=True)

        # 3. Model Accuracy Info Badge (Nilai Kebenaran dari Paper)
        accuracy_frame = tk.Frame(container, bg="#d1fae5", highlightbackground="#10b981", highlightthickness=1, bd=0)
        accuracy_frame.pack(fill="x", pady=(0, 10))
        lbl_accuracy = tk.Label(accuracy_frame, text="Tingkat Kebenaran (Akurasi) Model: 86.92%  (Sesuai Hasil MPE Paper)", bg="#d1fae5", fg="#065f46", font=self.font_label, pady=8)
        lbl_accuracy.pack()

        # 4. Input Frame
        input_frame = tk.LabelFrame(container, text=" Input Parameter ", bg=self.bg_card, fg=self.bg_primary, font=self.font_section, padx=15, pady=10, bd=1, relief="solid")
        input_frame.pack(fill="x", pady=5)

        # Permintaan Input
        lbl_permintaan = tk.Label(input_frame, text="Jumlah Permintaan (1000 - 1600 bungkus):", bg=self.bg_card, fg=self.text_dark, font=self.font_label)
        lbl_permintaan.grid(row=0, column=0, sticky="w", pady=5)
        self.entry_permintaan = tk.Entry(input_frame, font=("Helvetica", 10), width=15)
        self.entry_permintaan.grid(row=0, column=1, padx=10, pady=5)

        # Persediaan Input
        lbl_persediaan = tk.Label(input_frame, text="Jumlah Persediaan (600 - 900 bungkus):", bg=self.bg_card, fg=self.text_dark, font=self.font_label)
        lbl_persediaan.grid(row=1, column=0, sticky="w", pady=5)
        self.entry_persediaan = tk.Entry(input_frame, font=("Helvetica", 10), width=15)
        self.entry_persediaan.grid(row=1, column=1, padx=10, pady=5)

        # Calculate Button
        btn_hitung = tk.Button(input_frame, text="Hitung Prediksi & Evaluasi Aturan", command=self.proses_hitung, bg=self.bg_primary, fg=self.text_light, font=self.font_label, padx=15, pady=6, relief="flat")
        btn_hitung.grid(row=2, column=0, columnspan=2, pady=10)

        # 5. Result Frame
        self.result_frame = tk.Frame(container, bg="#e0e7ff", bd=1, relief="solid")
        self.result_frame.pack(fill="x", pady=5)
        
        self.lbl_result = tk.Label(self.result_frame, text="Hasil Prediksi: -", bg="#e0e7ff", fg=self.bg_primary, font=self.font_result, pady=12)
        self.lbl_result.pack()

        # 6. Rule Evaluation Frame
        self.rule_frame = tk.LabelFrame(container, text=" Detail Evaluasi Aturan (Nilai Kebenaran Premis / α-Predikat) ", bg=self.bg_card, fg=self.bg_primary, font=self.font_section, padx=10, pady=10, bd=1, relief="solid")
        self.rule_frame.pack(fill="both", expand=True, pady=5)

        # Initial rules display
        self.rule_labels = []
        self.setup_rules_ui()

    def setup_rules_ui(self):
        rules_desc = [
            ("R1", "IF Permintaan KECIL AND Persediaan SEDIKIT THEN Produksi SEDIKIT"),
            ("R2", "IF Permintaan KECIL AND Persediaan SEDANG THEN Produksi SEDIKIT"),
            ("R3", "IF Permintaan KECIL AND Persediaan BANYAK THEN Produksi SEDIKIT"),
            ("R4", "IF Permintaan SEDANG AND Persediaan SEDIKIT THEN Produksi SEDIKIT"),
            ("R5", "IF Permintaan SEDANG AND Persediaan SEDANG THEN Produksi SEDANG"),
            ("R6", "IF Permintaan SEDANG AND Persediaan BANYAK THEN Produksi SEDANG"),
            ("R7", "IF Permintaan BESAR AND Persediaan SEDIKIT THEN Produksi SEDIKIT"),
            ("R8", "IF Permintaan BESAR AND Persediaan SEDANG THEN Produksi SEDANG"),
            ("R9", "IF Permintaan BESAR AND Persediaan BANYAK THEN Produksi BANYAK"),
        ]
        
        # Header Row
        tk.Label(self.rule_frame, text="Aturan", bg=self.bg_card, fg=self.text_dark, font=self.font_label).grid(row=0, column=0, sticky="w", padx=5, pady=2)
        tk.Label(self.rule_frame, text="Pernyataan Aturan", bg=self.bg_card, fg=self.text_dark, font=self.font_label).grid(row=0, column=1, sticky="w", padx=5, pady=2)
        tk.Label(self.rule_frame, text="α-predikat", bg=self.bg_card, fg=self.text_dark, font=self.font_label).grid(row=0, column=2, sticky="e", padx=5, pady=2)
        tk.Label(self.rule_frame, text="Nilai z", bg=self.bg_card, fg=self.text_dark, font=self.font_label).grid(row=0, column=3, sticky="e", padx=5, pady=2)
        
        # Separator line
        sep = tk.Frame(self.rule_frame, height=1, bg=self.text_muted)
        sep.grid(row=1, column=0, columnspan=4, sticky="ew", pady=2)

        for i, (rid, desc) in enumerate(rules_desc):
            row_idx = i + 2
            
            lbl_id = tk.Label(self.rule_frame, text=rid, bg=self.bg_card, fg=self.text_muted, font=("Helvetica", 9, "bold"))
            lbl_id.grid(row=row_idx, column=0, sticky="w", padx=5, pady=1)
            
            lbl_desc = tk.Label(self.rule_frame, text=desc, bg=self.bg_card, fg=self.text_muted, font=("Helvetica", 9))
            lbl_desc.grid(row=row_idx, column=1, sticky="w", padx=5, pady=1)
            
            lbl_alpha = tk.Label(self.rule_frame, text="0.0000", bg=self.bg_card, fg=self.text_muted, font=("Helvetica", 9, "bold"))
            lbl_alpha.grid(row=row_idx, column=2, sticky="e", padx=5, pady=1)
            
            lbl_z = tk.Label(self.rule_frame, text="-", bg=self.bg_card, fg=self.text_muted, font=("Helvetica", 9))
            lbl_z.grid(row=row_idx, column=3, sticky="e", padx=5, pady=1)
            
            self.rule_labels.append({
                "id": lbl_id,
                "desc": lbl_desc,
                "alpha": lbl_alpha,
                "z": lbl_z
            })

    def proses_hitung(self):
        try:
            permintaan = float(self.entry_permintaan.get())
            persediaan = float(self.entry_persediaan.get())

            if not (1000 <= permintaan <= 1600) or not (600 <= persediaan <= 900):
                messagebox.showerror("Error Validasi", "Nilai input di luar rentang batas semesta!\nPermintaan: 1000 - 1600\nPersediaan: 600 - 900")
                return

            hasil, rules = self.service.calculate(permintaan, persediaan)
            
            # Update prediction result
            self.lbl_result.config(text=f"Hasil Prediksi: {round(hasil)} Bungkus")
            
            # Update rules details visually
            for i, item in enumerate(rules):
                alpha_val = item["alpha"]
                z_val = item["z"]
                
                # Format string alpha
                alpha_str = f"{alpha_val:.4f}"
                self.rule_labels[i]["alpha"].config(text=alpha_str)
                self.rule_labels[i]["z"].config(text=str(z_val))
                
                # Visual highlighting if rule is active (alpha > 0)
                if alpha_val > 0:
                    self.rule_labels[i]["id"].config(fg="#4f46e5")
                    self.rule_labels[i]["desc"].config(fg="#1e293b", font=("Helvetica", 9, "bold"))
                    self.rule_labels[i]["alpha"].config(fg="#10b981")
                    self.rule_labels[i]["z"].config(fg="#1e293b", font=("Helvetica", 9, "bold"))
                else:
                    self.rule_labels[i]["id"].config(fg=self.text_muted)
                    self.rule_labels[i]["desc"].config(fg=self.text_muted, font=("Helvetica", 9))
                    self.rule_labels[i]["alpha"].config(fg=self.text_muted)
                    self.rule_labels[i]["z"].config(fg=self.text_muted, font=("Helvetica", 9))

        except ValueError:
            messagebox.showerror("Error Input", "Masukkan nilai angka yang valid!")

if __name__ == "__main__":
    window = tk.Tk()
    app = FuzzyApp(window)
    window.mainloop()
