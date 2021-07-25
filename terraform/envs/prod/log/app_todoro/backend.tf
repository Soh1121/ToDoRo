terraform {
  backend "s3" {
    bucket = "todoro-tfstate"
    key    = "todoro/prod/log/app_todoro_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}
