# base image
FROM node:13-alpine AS build

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
COPY src /app/src
COPY public /app/public
COPY package.json /app

RUN npm install
RUN npm run-script build

FROM nginx:alpine AS serve

COPY --from=build /app/build /srv/app
COPY fpm.conf /etc/nginx/conf.d/default.conf

