terraform {
  backend "s3" {
    bucket = "todoro-tfstate"
    key    = "todoro/prod/app/todoro_v1.0.1.tfstate"
    region = "ap-northeast-1"
  }
}
