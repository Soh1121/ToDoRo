data "aws_caller_identity" "self" {}

data "aws_region" "current" {}

data "terraform_remote_state" "network_main" {
  backend = "s3"

  config = {
    bucket = "todoro-tfstate"
    key    = "${local.service_name}/${local.env_name}/network/main_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}

data "terraform_remote_state" "routing_todoro_tokyo" {
  backend = "s3"

  config = {
    bucket = "todoro-tfstate"
    key    = "${local.service_name}/${local.env_name}/routing/todoro_tokyo_v1.0.0.tfstate"
    region = "ap-northeast-1"
  }
}
