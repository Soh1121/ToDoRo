resource "aws_iam_user" "circleci" {
  name = "${local.name_prefix}-${local.service_name}-circleci"

  tags = {
    Name = "${local.name_prefix}-${local.service_name}-circleci"
  }
}

resource "aws_iam_role" "deployer" {
  name = "${local.name_prefix}-${local.service_name}-deployer"

  assume_role_policy = jsonencode(
    {
      "Version": "2012-10-17",
      "Statement": [
        {
          "Effect": "Allow",
          "Action": [
            "sts:AssumeRole",
            "sts:TagSession"
          ],
          "Principal": {
            "AWS": aws_iam_user.circleci.arn
          }
        }
      ]
    }
  )

  tags = {
    Name = "${local.name_prefix}-${local.service_name}-deployer"
  }
}
