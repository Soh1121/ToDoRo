data "terraform_remote_state" "network_main" {
  backend = "s3"

  config = {
    bucket = "todoro-tfstate"
    key    = "${local.service_name}/${local.env_name}/network/main_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}

data "terraform_remote_state" "db_todoro" {
  backend = "s3"

  config = {
    bucket = "todoro-tfstate"
    key    = "${local.service_name}/${local.env_name}/db/todoro_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}

data "terraform_remote_state" "cache_todoro" {
  backend = "s3"

  config = {
    bucket = "todoro-tfstate"
    key = "${local.service_name}/${local.env_name}/cache/todoro_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}
