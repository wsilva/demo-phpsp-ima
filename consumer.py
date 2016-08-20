#!/usr/bin/env python
# -*- coding: utf-8 -*-
import pika, json, time

print(' [*] Subindo consumer')
time.sleep(10)

print(' [*] Tentando conectar no rabbitmq')
credentials = pika.PlainCredentials('user', 'pass')
parameters = pika.ConnectionParameters('queue', 5672, '/', credentials)
connection = pika.BlockingConnection(parameters)
channel = connection.channel()

channel.queue_declare(queue='phpspima', durable=True)

def callback(ch, method, properties, body):
    # print(" [x] Received %r" % body)
    jsonbody = json.loads(body)
    print(" [-] Novo e-mail cadastrado: %s" % jsonbody['data']['novo-email'])

channel.basic_consume(callback, queue='phpspima', no_ack=True)

print(' [*] De pé e aguardando mensagens. CTRL+C para finalizar')
channel.start_consuming()