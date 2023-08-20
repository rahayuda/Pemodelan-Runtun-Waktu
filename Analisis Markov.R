library(markovchain)
library(diagram)
library(expm)

data(rain)
View(rain)
mysequence<-rain$rain
createSequenceMatrix(mysequence)

head(rain)

myFit<-markovchainFit(data=mysequence,confidencelevel = .9,method = "mle")
myFit

alofiMc<-myFit$estimate
alofiMc

a11=alofiMc[1,1]
a12=alofiMc[1,2]
a13=alofiMc[1,3]
a21=alofiMc[2,1]
a22=alofiMc[2,2]
a23=alofiMc[2,3]
a31=alofiMc[3,1]
a32=alofiMc[3,2]
a33=alofiMc[3,3]

stateNames <- c("No Rain","Light Rain","Heavy Rain")
ra <- matrix(c(a11,a12,a13,a21,a22,a23,a31,a32,a33),nrow=3, byrow=TRUE)

dtmcA <- new("markovchain",transitionMatrix=ra, states=c("No Rain","Light Rain","Heavy Rain"), name="MarkovChain A")
dtmcA

plot(dtmcA)

row.names(ra) <- stateNames; colnames(ra) <- stateNames
ra = round(ra,3)
plotmat(ra,pos = c(1,2), 
        lwd = 1, box.lwd = 2, 
        cex.txt = 0.8, 
        box.size = 0.1, 
        box.type = "circle", 
        box.prop = 0.5,
        box.col = "light blue",
        arr.length=.1,
        arr.width=.1,
        self.cex = .4,
        self.shifty = -.01,
        self.shiftx = .13,
        main = "Markov Chain Transition Matrix")

x1 <- matrix(c(1,0,0),nrow=1, byrow=TRUE)

x1 %*% ra

ra2 <- ra %^% 2
ra3 <- ra %^% 3
ra4 <- ra %^% 4
ra5 <- ra %^% 5
ra6 <- ra %^% 6
ra7 <- ra %^% 7

cat("Day 1 Forecast")
round(x1%*%ra,3)

cat("Day 2 Forecast")
round(x1%*%ra2,3)

cat("Day 7 Forecast")
round(x1%*%ra7,3)

ra7=round(ra7,3)

plotmat(ra7,pos = c(1,2), 
        lwd = 1, box.lwd = 2, 
        cex.txt = 0.8, 
        box.size = 0.1, 
        box.type = "circle", 
        box.prop = 0.5,
        box.col = "light blue",
        arr.length=.1,
        arr.width=.1,
        self.cex = .6,
        self.shifty = -.01,
        self.shiftx = .14,
        main = "The transition matrix after 7 days")

