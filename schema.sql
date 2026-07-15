(1/4) Installing ncurses-terminfo-base (6.6_p20260516-r0)
(2/4) Installing libncursesw (6.6_p20260516-r0)
(3/4) Installing readline (8.3.3-r1)
(4/4) Installing sqlite (3.53.2-r0)
Executing busybox-1.37.0-r31.trigger
OK: 10.7 MiB in 20 packages
CREATE TABLE "workflow_entity" ("id" varchar(36) PRIMARY KEY NOT NULL, "name" varchar(128) NOT NULL, "active" boolean NOT NULL, "nodes" text, "connections" text, "settings" text, "staticData" text, "pinData" text, "versionId" varchar(36) NOT NULL, "triggerCount" integer DEFAULT (0), "meta" text, "parentFolderId" varchar(36), "createdAt" datetime(3) NOT NULL DEFAULT (STRFTIME('%Y-%m-%d %H:%M:%f', 'NOW')), "updatedAt" datetime(3) NOT NULL DEFAULT (STRFTIME('%Y-%m-%d %H:%M:%f', 'NOW')), "isArchived" boolean NOT NULL DEFAULT (FALSE), "versionCounter" integer NOT NULL DEFAULT (1), "description" text, "activeVersionId" varchar(36), "nodeGroups" text NOT NULL DEFAULT ('[]'), "sourceWorkflowId" varchar, CONSTRAINT "FK_04a4db5906fbc5606c71448d912" FOREIGN KEY ("parentFolderId") REFERENCES "folder" ("id") ON DELETE CASCADE ON UPDATE NO ACTION, CONSTRAINT "FK_08d6c67b7f722b0039d9d5ed620" FOREIGN KEY ("activeVersionId") REFERENCES "workflow_history" ("versionId") ON DELETE RESTRICT ON UPDATE NO ACTION);
CREATE INDEX "IDX_e10425f6ab9964c4c1623a4a03" ON "workflow_entity" ("name") ;
CREATE TRIGGER "workflow_version_increment"
			AFTER UPDATE ON "workflow_entity"
			FOR EACH ROW
			WHEN OLD."versionCounter" = NEW."versionCounter"
				AND (OLD."nodes" IS NOT NEW."nodes" OR OLD."settings" IS NOT NEW."settings")
			BEGIN
				UPDATE "workflow_entity"
				SET "versionCounter" = "versionCounter" + 1
				WHERE "id" = NEW."id";
			END;
CREATE INDEX "IDX_workflow_entity_sourceWorkflowId" ON "workflow_entity" ("sourceWorkflowId") WHERE "sourceWorkflowId" IS NOT NULL;
