terraform {
  backend "s3" {
    bucket = "todoro-tfstate"
    key    = "torodo/prod/log/alb_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}
