package ua.`in`.mambo.shadowgame

import android.content.Context
import android.os.Bundle
import android.os.VibrationEffect
import android.os.Vibrator
import android.view.MotionEvent
import android.view.View
import android.view.WindowManager
import androidx.appcompat.app.AppCompatActivity
import android.widget.Toast
import androidx.coordinatorlayout.widget.CoordinatorLayout
import android.graphics.Point
import java.lang.Integer.min
import kotlin.math.sqrt


class MainActivity : AppCompatActivity() {

    //Vibrator vibrator
    private lateinit var vibrator: Vibrator
    private var x = 0
    private var y = 0
    private var screen_height = 0
    private var screen_width = 0
    private var max_distance = 0

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        //TODO: notch
        setContentView(R.layout.activity_main)


        val layout = findViewById<CoordinatorLayout>(R.id.linear_layout)
        layout.setOnTouchListener(touchListener)

        val attrib = window.attributes
        attrib.layoutInDisplayCutoutMode = WindowManager.LayoutParams.LAYOUT_IN_DISPLAY_CUTOUT_MODE_SHORT_EDGES

        vibrator = this.getSystemService(Context.VIBRATOR_SERVICE) as Vibrator

        val display = windowManager.defaultDisplay
        val size = Point()
        display.getSize(size)
        screen_width = size.x
        screen_height = size.y
        max_distance = sqrt((screen_height*screen_height+screen_width*screen_width).toDouble()).toInt()

        generatePoint()

    }

    private fun generatePoint(){
        x=(0..screen_width).random()
        y=(0..screen_height).random()
    }

    private var touchListener: View.OnTouchListener = View.OnTouchListener { _, event ->
        if(x == y && x == 0)
            generatePoint();
        if (event.actionMasked == MotionEvent.ACTION_DOWN) {

            val mistake_x = x-event.rawX
            val mistake_y = y-event.rawY
            val mistake = sqrt(mistake_x*mistake_x+mistake_y*mistake_y)


            //Toast.makeText(applicationContext, ""+(255*mistake/max_distance).toInt(),Toast.LENGTH_SHORT).show()
            if((255*mistake/max_distance)<10){
                vibrator.vibrate(VibrationEffect.createOneShot(1000, 1))
                generatePoint()
            }
            else
                vibrator.vibrate(VibrationEffect.createOneShot((255*mistake/max_distance).toLong(), 1))


        }
        false
    }
}
