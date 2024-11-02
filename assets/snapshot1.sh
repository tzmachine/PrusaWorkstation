#!/bin/sh
fingerprint="3595cd6a04abd3972850f92e214bbd9c76468f9f"  #get fingerprint from dev tool on website https://webcam.connec>token="t9hamOfw7SEyWrKHhmIu"    #camera api
name="image1.jpg"
temp=$(vcgencmd measure_temp | cut -d "=" -f2)
token="t9hamOfw7SEyWrKHhmIu"

while true;  do
chamber_temp=$(python /home/pw/PrusaWorkstation/read_temp.py)
fswebcam -d /dev/video0 -r 1280x960 --top-banner --info "Pi Temp: $temp" --title "Chamber Temp: $chamber_temp" --text-colour \#fa6831 --banner-colour \#3D333F50 --line-colour \#fa6831 --rotate 270 --set contrast=20% --set saturation=35% --set  brightness=20% image1.jpg

curl -T $name 'https://connect.prusa3d.com/c/snapshot' --header "token: ${token}" --header "fingerprint: ${fingerprint}"
sleep 8

done
