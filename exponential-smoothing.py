import numpy as np
import matplotlib.pyplot as plt

# Jumlah bulan dari Januari hingga Juli
months = 7

# Fungsi untuk menghitung Single Exponential Smoothing (SES)
def calculate_ses(suhu):
    alpha = 0.3  # Faktor penghalus
    ses = np.zeros(months)  # Array untuk hasil SES
    ses[0] = suhu[0]  # Nilai awal SES

    for i in range(1, months):
        ses[i] = alpha * suhu[i - 1] + (1 - alpha) * ses[i - 1]

    return ses

# Fungsi untuk menghitung Double Exponential Smoothing (DES)
def calculate_des(suhu):
    alpha = 0.3  # Faktor penghalus level
    beta = 0.2   # Faktor penghalus tren

    L = np.zeros(months)  # Level
    T = np.zeros(months)  # Tren
    des = np.zeros(months)  # Array untuk hasil DES

    # Inisialisasi nilai awal
    L[0] = suhu[0]
    T[0] = suhu[1] - suhu[0]  # Tren awal

    des[0] = suhu[0]

    for i in range(1, months):
        L[i] = (alpha * suhu[i - 1]) + (1 - alpha) * (L[i - 1] + T[i - 1])
        T[i] = beta * (L[i] - L[i - 1]) + (1 - beta) * T[i - 1]
        des[i] = L[i] + T[i]  # Suhu ramalan

    return des

# Fungsi untuk menghitung Triple Exponential Smoothing (TES)
def calculate_tes(suhu):
    alpha = 0.3  # Faktor penghalus level
    beta = 0.2   # Faktor penghalus tren
    gamma = 0.1  # Faktor penghalus musiman

    L = np.zeros(months)  # Level
    T = np.zeros(months)  # Tren
    S = np.zeros(months)  # Musiman
    tes = np.zeros(months)  # Array untuk hasil TES

    # Inisialisasi nilai awal
    L[0] = suhu[0]
    T[0] = suhu[1] - suhu[0]  # Tren awal

    # Asumsikan musiman awal adalah 0
    S[0] = 0  # Musiman awal

    tes[0] = L[0] + S[0]  # TES pertama

    for i in range(1, months):
        L[i] = (alpha * suhu[i - 1]) + (1 - alpha) * (L[i - 1] + T[i - 1] + S[i - 1])
        T[i] = (beta * (L[i] - L[i - 1])) + (1 - beta) * T[i - 1]
        S[i] = (gamma * (L[i] - L[i - 1])) + (1 - gamma) * S[i - 1]  # Seasonal calculation
        tes[i] = L[i] + T[i] + S[i]  # Suhu ramalan

    return tes

def main():
    suhu = np.array([15, 17, 20, 22, 25, 28, 30])  # Data suhu (termasuk Juli)
    
    ses = calculate_ses(suhu)
    des = calculate_des(suhu)
    tes = calculate_tes(suhu)

    # Menampilkan hasil
    print(f"{'Bulan':<5}{'Suhu':<8}{'SES':<8}{'DES':<8}{'TES':<8}")
    print("-" * 40)
    for i in range(months):
        month = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"][i]
        print(f"{month:<5}{suhu[i]:<8}{ses[i]:<8.2f}{des[i]:<8.2f}{tes[i]:<8.2f}")

    # Membuat grafik
    plt.figure(figsize=(10, 6))
    plt.plot(range(months), suhu, marker='o', label='Suhu Aktual', color='blue')
    plt.plot(range(months), ses, marker='o', label='Single Exponential Smoothing (SES)', color='orange')
    plt.plot(range(months), des, marker='o', label='Double Exponential Smoothing (DES)', color='green')
    plt.plot(range(months), tes, marker='o', label='Triple Exponential Smoothing (TES)', color='red')

    # Menambahkan detail grafik
    plt.title('Peramalan Suhu Menggunakan Exponential Smoothing')
    plt.xlabel('Bulan')
    plt.ylabel('Suhu (°C)')
    plt.xticks(range(months), ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul"])
    plt.legend()
    plt.grid()
    plt.show()

if __name__ == "__main__":
    main()
