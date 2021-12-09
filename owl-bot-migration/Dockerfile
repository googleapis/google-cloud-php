# Copyright 2021 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     https://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

FROM python:3.9.5-buster

WORKDIR /

COPY migrate-to-owlbot.py /
COPY tmpl /tmpl
COPY requirements.txt /
RUN chmod 0755 /migrate-to-owlbot.py
RUN chmod 0755 /tmpl
RUN chmod 0644 /tmpl/*

RUN python -m pip install -r requirements.txt

ENTRYPOINT ["/migrate-to-owlbot.py"]
