#function to calculate the dutycycle, proportional between goal temp and max temp
def calcDutyCycle(r_t, g_t, max_t):
	if r_t <= g_t:
		return 0
	elif r_t >= max_t:
		return 100
	else:
		return	(r_t-g_t)/(max_t-g_t) *100