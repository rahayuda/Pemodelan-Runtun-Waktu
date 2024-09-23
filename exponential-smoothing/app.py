from flask import Flask, render_template
import matplotlib.pyplot as plt

app = Flask(__name__)

@app.route('/')
def index():
    # Historical data
    observed = [15, 17, 20, 22, 25, 28]
    months = ['January', 'February', 'March', 'April', 'May', 'June', 'July']

    # SES calculations
    alpha = 0.3
    ses_forecast = [observed[0]]  # Initial forecast for January
    for i in range(1, len(observed) + 1):
        if i < len(observed):
            forecast = alpha * observed[i - 1] + (1 - alpha) * ses_forecast[i - 1]
            ses_forecast.append(forecast)
        else:
            forecast = alpha * observed[i - 1] + (1 - alpha) * ses_forecast[i - 1]
            ses_forecast.append(forecast)

    # DES calculations
    beta = 0.2
    des_forecast = [observed[0]]  # Initial level
    trend = observed[1] - observed[0]  # Initial trend
    for i in range(1, len(observed) + 1):
        if i < len(observed):
            level = alpha * observed[i] + (1 - alpha) * (des_forecast[i - 1] + trend)
            trend = beta * (level - des_forecast[i - 1]) + (1 - beta) * trend
            des_forecast.append(level)
        else:
            level = alpha * observed[i - 1] + (1 - alpha) * (des_forecast[i - 1] + trend)
            des_forecast.append(level)

    # TES calculations
    gamma = 0.1
    tes_forecast = [observed[0]]  # Initial level
    trend = observed[1] - observed[0]  # Initial trend
    seasonality = 0  # Initial seasonality
    for i in range(1, len(observed) + 1):
        if i < len(observed):
            level = alpha * observed[i] + (1 - alpha) * (tes_forecast[i - 1] + trend + seasonality)
            tes_forecast.append(level)
            trend = beta * (level - tes_forecast[i - 1]) + (1 - beta) * trend
            seasonality = gamma * (observed[i] - tes_forecast[i]) + (1 - gamma) * seasonality
        else:
            level = alpha * observed[i - 1] + (1 - alpha) * (tes_forecast[i - 1] + trend + seasonality)
            tes_forecast.append(level)

    # Create the graph
    plt.figure(figsize=(10, 5))
    plt.plot(months, observed + [None], label='Observed', marker='o')  # Adding None for July observed
    plt.plot(months, ses_forecast, label='SES Forecast', marker='o')
    plt.plot(months, des_forecast, label='DES Forecast', marker='o',color='gray')
    plt.plot(months, tes_forecast, label='TES Forecast', marker='o')

    plt.title('Weather Forecasting (January to July)')
    plt.xlabel('Months')
    plt.ylabel('Temperature (°C)')
    plt.legend()
    plt.grid()
    plt.savefig('static/forecast_chart.png')
    plt.close()

    # Prepare results
    ses_result = f"SES Forecast for July: {ses_forecast[-1]:.2f}°C"
    des_result = f"DES Forecast for July: {des_forecast[-1]:.2f}°C"
    tes_result = f"TES Forecast for July: {tes_forecast[-1]:.2f}°C"

    return render_template('index.html', ses_result=ses_result, des_result=des_result, tes_result=tes_result, forecast_image='forecast_chart.png')

if __name__ == '__main__':
    app.run(debug=True)
