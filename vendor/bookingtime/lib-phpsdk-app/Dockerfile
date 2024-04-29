# main settings
ARG APP_ENV
FROM ghcr.io/bookingtime/symfony-cli-os:8.2-${APP_ENV}
LABEL maintainer="d.kokot@bookingtime.com"

# set environment variables for building process
ARG APP_ENV
ARG COMPOSER_AUTH=""
ENV APP_ENV=$APP_ENV
ENV REPO="lib-phpsdk-app"

# check for mandatory build arguments
RUN if [ "$APP_ENV" != "local" ] && [ "$APP_ENV" != "test" ] ; then echo "Invalid APP_ENV ARG submitted: $APP_ENV" ; exit 1 ; else echo "Submitted APP_ENV: $APP_ENV" ; fi

# copy source-code to cli-root
COPY . /usr/src/myapp

# composer install dependencies
RUN if [ "$APP_ENV" = "local" ] || [ "$APP_ENV" = "test" ] ; then composer install --quiet --no-interaction ; fi

# fix permissions
RUN chmod a+x /usr/src/myapp/bin/console

# update locate database
RUN if [ "$APP_ENV" = "local" ] ; then updatedb ; fi

# set default command
CMD [ "php", "./app.php" ]
