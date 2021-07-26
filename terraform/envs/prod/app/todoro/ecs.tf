resource "aws_ecs_cluster" "this" {
  name = "${local.name_prefix}-${local.service_name}"

  capacity_providers = [
    "FARGATE",
    "FARGATE_SPOT"
  ]

  tags = {
    Name = "${local.name_prefix}-${local.service_name}"
  }
}

resource "aws_ecs_task_definition" "this" {
  family = "${local.name_prefix}-${local.service_name}"

  task_role_arn = aws_iam_role.ecs_task.arn

  network_mode = "awsvpc"

  requires_compatibilities = [
    "FARGATE",
  ]

  execution_role_arn = aws_iam_role.ecs_task_execution.arn

  memory = "512"
  cpu    = "256"

  container_definitions = jsonencode(
    [
      {
        name  = "nginx"
        image = "${module.nginx.ecr_repository_this_repository_url}:latest"

        portMappings = [
          {
            hostPort      = 80
            containerPort = 80
          }
        ]

        environment = []
        secrets     = []

        dependsOn = [
          {
            containerName = "php"
            condition     = "START"
          }
        ]

        logConfiguration = {
          logDriver = "awslogs"
          options = {
            awslogs-group         = "/ecs/${local.name_prefix}-${(local.service_name)}/nginx"
            awslogs-region        = data.aws_region.current.id
            awslogs-stream-prefix = "ecs"
          }
        }
      },
      {
        name  = "php"
        image = "${module.php.ecr_repository_this_repository_url}:latest"

        portMappings = [
          {
            hostPort      = 9000
            containerPort = 9000
          }
        ]

        environment = []
        secrets = [
          {
            name      = "APP_KEY"
            valueFrom = "/${local.service_name}/${local.env_name}/${local.service_name}/APP_KEY"
          }
        ]

        # mountPoints = [
        #   {
        #     # 自分の環境に合わせて
        #     containerPath = ""
        #     sourceVolume = ""
        #   }
        # ]

        logConfiguration = {
          logDriver = "awslogs"
          options = {
            awslogs-group         = "/ecs/${local.name_prefix}-${(local.service_name)}/php"
            awslogs-region        = data.aws_region.current.id
            awslogs-stream-prefix = "ecs"
          }
        }
      }
    ]
  )

  volume {
    name = "nginx-laravel-spa"
  }

  tags = {
    Name = "${local.name_prefix}-${local.service_name}"
  }
}
