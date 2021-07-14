variable "aws_access_key" {}
variable "aws_secret_key" {}
variable "aws_session_token" {}

provider "aws" {
  access_key = var.aws_access_key
  secret_key = var.aws_secret_key
  token      = var.aws_session_token
  region     = "ap-northeast-1"

  default_tags {
    tags = {
      Env    = "prod"
      System = "todoro"
    }
  }
}

terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "3.42.0"
    }
  }

  required_version = "1.0.1"
}
