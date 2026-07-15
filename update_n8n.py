import sqlite3
import json

db_path = 'database.sqlite'
conn = sqlite3.connect(db_path)
c = conn.cursor()

c.execute("SELECT id, nodes, connections FROM workflow_entity")
rows = c.fetchall()

for row in rows:
    id = row[0]
    nodes = json.loads(row[1])
    
    # We want to replace the nodes with a direct connection
    new_nodes = [
        {
          "parameters": {
            "httpMethod": "POST",
            "path": "c30ceb14-6917-4c48-93ed-e527da9b958e",
            "options": {}
          },
          "type": "n8n-nodes-base.webhook",
          "typeVersion": 2.1,
          "position": [0, 0],
          "id": "1890a27c-eb21-43ec-a0a4-bfa4a18b6b51",
          "name": "Webhook",
          "webhookId": "c30ceb14-6917-4c48-93ed-e527da9b958e"
        },
        {
          "parameters": {
            "fromEmail": "gozzzgas@gmail.com",
            "toEmail": "={{ $json.body.target_email }}",
            "subject": "=Notifikasi Peminjaman Alat",
            "html": "={{ $json.body.email_body_html }}",
            "options": {}
          },
          "type": "n8n-nodes-base.emailSend",
          "typeVersion": 2.1,
          "position": [200, 0],
          "id": "506c8cb2-cccc-47c6-9800-5cccca9d60ea",
          "name": "Send Email",
          "webhookId": "13becc86-a7d2-4cbe-a1f8-527d76782092",
          "credentials": {
            "smtp": {
              "id": "NUw1yxmcD7zXygV4",
              "name": "SMTP account"
            }
          }
        }
    ]
    
    new_connections = {
      "Webhook": {
        "main": [
          [
            {
              "node": "Send Email",
              "type": "main",
              "index": 0
            }
          ]
        ]
      }
    }
    
    c.execute("UPDATE workflow_entity SET nodes = ?, connections = ? WHERE id = ?", (json.dumps(new_nodes), json.dumps(new_connections), id))

conn.commit()
conn.close()
