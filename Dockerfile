FROM quay.io/continuouspipe/symfony-php7.1-apache:latest
ARG DEVELOPMENT_MODE=true

COPY . /app/
RUN container build
