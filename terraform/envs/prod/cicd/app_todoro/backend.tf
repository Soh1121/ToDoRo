terraform {
  backend "s3" {
    bucket = "todoro-tfstate"
    key    = "todoro/prod/cicd/app_todoro_v1.0.1.tfstate"
    region = "ap-northeast-1"
  }
}
