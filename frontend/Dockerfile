# base image
FROM node:13-alpine AS build

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
COPY package.json /app/package.json
RUN npm install

FROM nginx:latest AS serve

COPY --from=build /app/build /srv/www

