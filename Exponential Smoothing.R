#analisis time series - exponential smoothing#

data = Data_Laporan_Bulanan

data = ts(data, start=c(2015,1), end=c(2019,12), frequency = 12)

ts.plot(data)

foreSingle = HoltWinters(data, beta = F, gamma = F)
foreSingleforeSingle$SSE
plot(foreSingle)

foreDouble = HoltWinters(data, gamma = F)
foreDouble
foreDouble$SSE
plot(foreDouble)

foreTriple = HoltWinters(data)
foreTriple
foreTriple$SSE
plot(foreTriple)

allSSE <- data.frame(Metode=c("single Exponential Smoothing",
                              "Double Exponential Smoothing Hot1",
                              "Triple Exponential Smoothing Holt-winters"),
                     SSE=c(foreSingle$SSE,
                           foreDouble$SSE,
                           foreTriple$SSE))
View(allSSE)

predict(foreTriple, n.ahead = 8)

