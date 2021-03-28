import datetime

x = datetime.datetime.now()
print(x.year)
x = datetime.datetime.utcnow()  # UTC0 now
y = datetime.datetime(2020, 1, 15)
z = datetime.datetime(2020, 1, 15, 1, 30, 59)
print(z.strftime("Weekday: %A (%a %w)\n"
                 "Month Day: %d\n"
                 "Month: %B (%b %m)\n"
                 "Year: %Y (%y)\n"
                 "Hour: %H (%h %p)\n"
                 "Minute: %M\n"
                 "Second: %S\n"
                 "Microsecond: %f\n"
                 "Timezone: %Z (%z)\n"
                 "Year day: %j\n"
                 "Week Number: %U (or monday %W)\n"
                 "Formatted date and time: %x %X\n"
                 "Formatted full date: %c\n"))
