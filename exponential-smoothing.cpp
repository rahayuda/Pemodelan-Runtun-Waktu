#include <iostream>
#include <iomanip>

using namespace std;

const int months = 7; // Total bulan dari Januari hingga Juli

// Fungsi untuk menghitung Single Exponential Smoothing (SES)
void calculateSES(double suhu[], double ses[]) {
    double alpha = 0.3; // Faktor penghalus
    ses[0] = suhu[0]; // Nilai awal SES

    for (int i = 1; i < months; i++) {
        ses[i] = alpha * suhu[i - 1] + (1 - alpha) * ses[i - 1];
    }
}

// Fungsi untuk menghitung Double Exponential Smoothing (DES)
void calculateDES(double suhu[], double des[]) {
    double alpha = 0.3; // Faktor penghalus level
    double beta = 0.2;  // Faktor penghalus tren

    double L[months] = {0}; // Level
    double T[months] = {0}; // Tren

    // Inisialisasi nilai awal
    L[0] = suhu[0];
    T[0] = suhu[1] - suhu[0]; // Tren awal

    des[0] = suhu[0]+T[0];

    for (int i = 1; i < months; i++) 
    {
        L[i] = (alpha * suhu[i-1]) + ((1 - alpha) * (L[i - 1] + T[i - 1]));
        T[i] = beta * (L[i] - L[i - 1]) + (1 - beta) * T[i - 1];
        des[i] = L[i] + T[i]; // Suhu ramalan
    }
}

// Fungsi untuk menghitung Triple Exponential Smoothing (TES)
void calculateTES(double suhu[], double tes[]) {
    double alpha = 0.3; // Faktor penghalus level
    double beta = 0.2;  // Faktor penghalus tren
    double gamma = 0.1; // Faktor penghalus musiman

    double L[months] = {0}; // Level
    double T[months] = {0}; // Tren
    double S[months] = {0}; // Musiman

    // Inisialisasi nilai awal
    L[0] = suhu[0];
    T[0] = suhu[1] - suhu[0]; // Tren awal
    S[0] = 0; // Musiman awal

    tes[0] = L[0] + T[0] + S[0];

    for (int i = 1; i < months; i++) {
        L[i] = (alpha * suhu[i-1]) + ((1 - alpha) * (L[i - 1] + T[i - 1] + S[i - 1]));
        T[i] = (beta * (L[i] - L[i - 1])) + ((1 - beta) * T[i - 1]);
        S[i] = (gamma * (L[i] - L[i - 1])) + ((1 - gamma) * S[i - 1]);
        tes[i] = L[i] + T[i] + S[i]; // Suhu ramalan
    }
}

int main() {
    double suhu[months] = {15, 17, 20, 22, 25, 28}; // Data suhu
    double ses[months] = {0};
    double des[months] = {0};
    double tes[months] = {0};

    calculateSES(suhu, ses);
    calculateDES(suhu, des);
    calculateTES(suhu, tes);

    cout << fixed << setprecision(2);
    cout << "Bulan\tSuhu\tSES\tDES\tTES\n";
    cout << "-----------------------------------\n";
    cout << "Jan\t" << suhu[0] << "\t" << ses[0] << "\t" << des[0] << "\t" << tes[0] << "\n";
    cout << "Feb\t" << suhu[1] << "\t" << ses[1] << "\t" << des[1] << "\t" << tes[1] << "\n";
    cout << "Mar\t" << suhu[2] << "\t" << ses[2] << "\t" << des[2] << "\t" << tes[2] << "\n";
    cout << "Apr\t" << suhu[3] << "\t" << ses[3] << "\t" << des[3] << "\t" << tes[3] << "\n";
    cout << "Mei\t" << suhu[4] << "\t" << ses[4] << "\t" << des[4] << "\t" << tes[4] << "\n";
    cout << "Jun\t" << suhu[5] << "\t" << ses[5] << "\t" << des[5] << "\t" << tes[5] << "\n";
    cout << "Jul\t" << "N/A" << "\t" << ses[6] << "\t" << des[6] << "\t" << tes[6] << "\n";

    return 0;
}
