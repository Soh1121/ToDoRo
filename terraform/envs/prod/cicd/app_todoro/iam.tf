resource "aws_iam_user" "circleci" {
  name = "${local.name_prefix}-${local.service_name}-circleci"

  tags = {
    Name = "${local.name_prefix}-${local.service_name}-circleci"
  }
}
