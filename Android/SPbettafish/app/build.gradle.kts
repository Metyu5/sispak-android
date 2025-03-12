plugins {
    alias(libs.plugins.android.application)
}

android {
    namespace = "uigu.sisteminformasi.spbettafish"
    compileSdk = 34

    defaultConfig {
        applicationId = "uigu.sisteminformasi.spbettafish"
        minSdk = 29
        targetSdk = 34
        versionCode = 1
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
}

dependencies {
    // Retrofit
    implementation(libs.retrofit)
    // Converter Gson
    implementation(libs.converterGson)
    // Optional: Logging Interceptor untuk debug jaringan
    implementation(libs.loggingInterceptor)
    implementation(libs.glide)
    annotationProcessor(libs.glideCompiler)
    implementation(libs.appcompat)
    implementation(libs.material)
    implementation(libs.activity)
    implementation(libs.constraintlayout)
    testImplementation(libs.junit)
    androidTestImplementation(libs.ext.junit)
    androidTestImplementation(libs.espresso.core)
    implementation(libs.picasso)
    implementation(libs.viewpager2)
}