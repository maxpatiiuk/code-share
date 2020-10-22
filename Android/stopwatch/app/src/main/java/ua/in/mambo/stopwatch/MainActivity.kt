package ua.`in`.mambo.stopwatch

import android.os.Bundle
import android.os.Handler
import android.os.Looper
import android.view.WindowManager
import android.widget.Button
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import kotlin.math.floor


class MainActivity : AppCompatActivity() {

    private var hour = 0
    private var minute = 0
    private var second = 0
    private var millisecond = 0
    private var startTime = 0L
    private var paused = true

    private lateinit var timeText: TextView
    private lateinit var mainHandler: Handler
    private lateinit var mRunnable: Runnable


    override fun onCreate(savedInstanceState: Bundle?) {

        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)


        timeText = findViewById(R.id.time)
        val prev = findViewById<Button>(R.id.prev)
        val next = findViewById<Button>(R.id.next)
        val toggle = findViewById<Button>(R.id.toggle)
        val resume = findViewById<Button>(R.id.resume)

        prev.setOnClickListener { prev() }
        next.setOnClickListener { next() }
        toggle.setOnClickListener { toggle() }
        resume.setOnClickListener { resume() }

        val attribute = window.attributes
        attribute.layoutInDisplayCutoutMode =
            WindowManager.LayoutParams.LAYOUT_IN_DISPLAY_CUTOUT_MODE_SHORT_EDGES

        mainHandler = Handler(Looper.getMainLooper())
        mRunnable = Runnable { }


    }

    private fun getMillisecond(long: Long): Int {

        val num = (long.toDouble() / 1000)

        return ((num - floor(num)) * 1000).toInt()
    }


    private fun updateTime(show_millisecond: Boolean = false) {

        var result: String
        val textViewHeight = timeText.height
        val paddingTopValue = (0.1*textViewHeight+textViewHeight/200*3*second.toDouble()).toInt()

        timeText.setPadding(0,paddingTopValue,0,0)

        when {
            hour != 0 -> {

                result = if(hour<10)
                    "0$hour:"
                else
                    "$hour:"

                result += if(minute<10)
                    "0$minute:"
                else
                    "$minute:"

                result += if(second<10)
                    "0$second"
                else
                    "$second"

            }
            minute != 0 -> {

                result = if(minute<10)
                    "0$minute:"
                else
                    "$minute:"

                result += if(second<10)
                    "0$second"
                else
                    "$second"

            }
            else -> {

                result = if(second<10)
                    "0$second"
                else
                    "$second"

            }
        }

        if (show_millisecond) {
            if (result.isNotEmpty())
                result += '.'

            millisecond = getMillisecond(System.currentTimeMillis() - startTime)

            result += "$millisecond"
        }

        timeText.text = result


    }

    private fun next() {

        second++

        if (second > 59) {
            minute++
            second -= 60
        }

        if (minute > 59) {
            hour--
            minute -= 60
        }

        updateTime()

    }

    private fun prev() {

        if (hour > 0 || minute > 0 || second > 0)
            second--

        if (second < 0) {
            minute--
            second = 60 - second
        }

        if (minute < 0) {
            hour--
            minute = 60 - minute
        }

        updateTime()

    }

    private fun toggle() {

        if (paused) {

            hour = 0
            minute = 0
            second = 0
            startTime = System.currentTimeMillis()

            startTimer()
            updateTime()

        } else {

            mainHandler.removeCallbacks(mRunnable)

            updateTime(true)

        }

        paused = !paused

    }

    private fun resume() {

        if (paused) {
            startTimer(1000 - millisecond)

            startTime = System.currentTimeMillis()

            paused = !paused
        }

    }


    private fun startTimer(delay: Int = 1000) {


        mRunnable = Runnable {

            next()

            mainHandler.postDelayed(mRunnable, 1000)

        }

        mainHandler.postDelayed(mRunnable, delay.toLong())

    }


}